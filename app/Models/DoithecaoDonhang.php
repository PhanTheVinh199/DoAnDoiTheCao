<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DoithecaoDonhang extends Model
{
    use HasFactory;

    protected $table = 'doithecao_donhang';
    protected $primaryKey = 'id_dondoithe';
    public $timestamps = false;

    protected $fillable = [
        'ma_don',
        'ma_the',
        'serial',
        'doithecao_id',
        'thanhvien_id',
        'so_luong',
        'thanh_tien',
        'ngay_tao',
        'trang_thai',
    ];

    public function doithecao()
    {
        return $this->belongsTo(DoithecaoDanhsach::class, 'doithecao_id', 'id_doithecao');
    }

    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id');
    }

    /**
     * Lấy danh sách đơn hàng có tìm kiếm và phân trang
     */
    public static function getDonHangWithFilter($searchTerm = '', $perPage = 10)
    {
        return self::with('doithecao', 'doithecao.nhacungcap', 'thanhvien')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('ma_don', 'like', '%' . $searchTerm . '%');
            })
            ->orderBy('ngay_tao', 'desc')
            ->paginate($perPage);
    }

    /**
     * Cập nhật trạng thái đơn hàng và cộng tiền vào tài khoản nếu trạng thái là 'hoat_dong'
     */
    public static function updateStatus($id_dondoithe, $trang_thai)
    {
        return DB::transaction(function () use ($id_dondoithe, $trang_thai) {
            $donhang = self::findOrFail($id_dondoithe);

            // Nếu chuyển trạng thái sang 'hoat_dong' và chưa cộng tiền thì cộng tiền
            if ($trang_thai === 'hoat_dong' && $donhang->trang_thai !== 'hoat_dong') {
                $thanhvien = $donhang->thanhvien;
                if ($thanhvien) {
                    $thanhvien->so_du += $donhang->thanh_tien;
                    $thanhvien->save();
                }
            }

            $donhang->trang_thai = $trang_thai;
            $donhang->save();

            return $donhang;
        });
    }
}
