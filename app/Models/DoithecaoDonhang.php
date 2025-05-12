<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoithecaoDonhang extends Model
{
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
        'ngay_tao',
        'trang_thai',
         'thanhvien_id', // Ensure this is included
    ];

    public function doithecao()
    {
        return $this->belongsTo(DoithecaoDanhsach::class, 'doithecao_id', 'id_doithecao');
    }
//     public function doithecao()
// {
//     return $this->hasMany(DoithecaoDonhang::class, 'thanhvien_id');  // 'thanhvien_id' là cột trong bảng doithecao_donhang
// }

   public function thanhvien()
{
    return $this->belongsTo(ThanhVien::class, 'thanhvien_id');
}
}
