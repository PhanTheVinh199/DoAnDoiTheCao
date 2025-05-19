<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RutTien extends Model
{
    use HasFactory;

    protected $table = 'lichsu_rut';
    protected $primaryKey = 'id_lichsurut';
    public $timestamps = true;

    protected $fillable = [
        'ma_don',
        'thanhvien_id',
        'danhsach_id',
        'so_tien_rut',
        'trang_thai',
        'created_at',
        'updated_at'
    ];

    public function nganhang()
    {
        return $this->belongsTo(NganHang::class, 'danhsach_id');
    }

    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id');
    }

    /**
     * Lấy danh sách lịch sử rút tiền của user, phân trang
     */
    public static function getUserRutTienHistory($userId, $perPage = 5)
    {
        return self::where('thanhvien_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Thêm ngân hàng cho user
     */
    public static function addUserBank($userId, array $data)
    {
        return NganHang::create([
            'thanhvien_id' => $userId,
            'ten_ngan_hang' => $data['ten_ngan_hang'],
            'so_tai_khoan' => $data['so_tai_khoan'],
            'chu_tai_khoan' => $data['chu_tai_khoan'],
            'trang_thai' => 'hoat_dong',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Thực hiện rút tiền
     * Trừ số dư user, tạo bản ghi lịch sử rút tiền
     */
    public static function processRutTien($user, $bankId, $amount)
    {
        if ($amount < 10000 || $amount > 5000000) {
            throw new \Exception('Số tiền rút không hợp lệ.');
        }
        if ($user->so_du < $amount) {
            throw new \Exception('Số dư tài khoản không đủ để rút.');
        }
        $bank = NganHang::find($bankId);
        if (!$bank || $bank->thanhvien_id != $user->id_thanhvien) {
            throw new \Exception('Ngân hàng không hợp lệ.');
        }

        // Giảm số dư
        $user->so_du -= $amount;
        $user->save();

        // Tạo mã đơn rút tiền
        $ma_don = 'RUT' . strtoupper(Str::random(8));

        // Lưu lịch sử rút tiền
        return self::create([
            'ma_don' => $ma_don,
            'thanhvien_id' => $user->id_thanhvien,
            'danhsach_id' => $bankId,
            'so_tien_rut' => $amount,
            'trang_thai' => 'cho_duyet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
