<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NapTien extends Model
{
    use HasFactory;

    protected $table = 'lichsu_nap';
    protected $primaryKey = 'id_lichsunap';

    protected $fillable = [
        'ma_don',
        'thanhvien_id',
        'so_tien_nap',
        'noi_dung',
        'ngay_tao',
        'trang_thai',
        'paygate_code',
        'bank_name',
        'bank_account',
        'bank_account_name',
        'transfer_note',
    ];
    protected $dates = ['updated_at', 'ngay_tao'];
    // Quan hệ tới bảng thành viên
    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }

    // Quan hệ tới bảng ngân hàng
    public function nganhang()
    {
        return $this->belongsTo(NganHang::class, 'paygate_code', 'id_danhsach');
    }

    /**
     * Lấy lịch sử nạp tiền phân trang, sắp xếp mới nhất
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPaginatedHistory($userId, $perPage = 10)
    {
        return self::where('thanhvien_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Tạo giao dịch nạp tiền mới
     * $data bao gồm: thanhvien_id, so_tien_nap, paygate_code,...
     * @throws \Exception
     */
    public static function createDeposit(array $data)
    {
        // Giới hạn nạp trong ngày, mặc định 100 triệu
        $hanMucNgay = $data['han_muc_ngay'] ?? 100000000;

        $totalToday = self::where('thanhvien_id', $data['thanhvien_id'])
            ->whereDate('created_at', now()->toDateString())
            ->sum('so_tien_nap');

        if ($totalToday + $data['so_tien_nap'] > $hanMucNgay) {
            throw new \Exception('Bạn đã đạt hạn mức nạp tiền trong ngày.');
        }

        $bank = NganHang::where('id_danhsach', $data['paygate_code'])
                        ->where('trang_thai', 'hoat_dong')
                        ->first();

        if (!$bank) {
            throw new \Exception('Ngân hàng không hợp lệ hoặc đã bị vô hiệu hóa.');
        }

        $dataToCreate = [
            'ma_don' => Str::uuid(),
            'thanhvien_id' => $data['thanhvien_id'],
            'so_tien_nap' => $data['so_tien_nap'],
            'noi_dung' => 'Nạp qua ngân hàng ' . $bank->ten_ngan_hang . ' (' . $bank->so_tai_khoan . ')',
            'trang_thai' => 'cho_duyet',
            'paygate_code' => $data['paygate_code'],
            'bank_name' => $bank->ten_ngan_hang,
            'bank_account' => $bank->so_tai_khoan,
            'bank_account_name' => $bank->chu_tai_khoan,
            'transfer_note' => 'NAP' . strtoupper(Str::random(6)),
        ];

        return self::create($dataToCreate);
    }

    /**
     * Cập nhật đơn nạp tiền theo id với dữ liệu truyền vào
     * @param int $id
     * @param array $data
     * @return NapTien
     */
    public static function updateNapTien($id, array $data)
    {
        $napTien = self::findOrFail($id);
        $napTien->update($data);
        return $napTien;
    }

    /**
     * Duyệt và cập nhật trạng thái giao dịch (admin dùng)
     * Nếu trạng thái là 'da_duyet', cộng tiền vào tài khoản thành viên
     * @throws \Exception
     */
    public static function approveTransaction($id, $newStatus)
    {
        return DB::transaction(function () use ($id, $newStatus) {
            $transaction = self::findOrFail($id);

            if ($transaction->trang_thai === 'huy') {
                throw new \Exception('Giao dịch đã bị hủy, không thể cập nhật.');
            }

            $transaction->trang_thai = $newStatus;
            $transaction->save();

            if ($newStatus === 'da_duyet') {
                $user = $transaction->thanhvien;
                if (!$user) {
                    throw new \Exception('Không tìm thấy người dùng.');
                }
                $user->so_du += $transaction->so_tien_nap;
                $user->save();
            }

            return $transaction;
        });
    }

    /**
     * Lấy chi tiết đơn nạp kèm thông tin ngân hàng
     */
    public static function getOrderDetail($id)
    {
        return self::with('nganhang')->findOrFail($id);
    }

    /**
     * Xác nhận giao dịch (cập nhật số dư nếu đã duyệt)
     */
    public static function confirmTransaction($id)
    {
        return DB::transaction(function () use ($id) {
            $order = self::findOrFail($id);

            if ($order->trang_thai === 'cho_duyet') {
                throw new \Exception('Giao dịch này vẫn chưa được admin phê duyệt.');
            }

            if ($order->trang_thai === 'da_duyet') {
                $user = $order->thanhvien;
                if (!$user) {
                    throw new \Exception('Không tìm thấy người dùng.');
                }
                $user->so_du += $order->so_tien_nap;
                $user->save();
                return $order;
            }

            throw new \Exception('Giao dịch không hợp lệ.');
        });
    }
}
