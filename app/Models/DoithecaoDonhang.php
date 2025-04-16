<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'so_luong',
        'thanh_tien',
        'thanhvien_id',
        'ngay_tao',
        'trang_thai',
    ];

    // Quan hệ với bảng doithecao_danhsach
    public function doithecao()
    {
        return $this->belongsTo(DoithecaoDanhsach::class, 'doithecao_id', 'id_doithecao');
    }

    // Quan hệ với bảng thanhvien
    public function thanhvien()
    {
        return $this->belongsTo(Thanhvien::class, 'thanhvien_id', 'id_thanhvien');
    }
}
