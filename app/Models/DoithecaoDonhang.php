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
        'thanhvien_id', // Add this line
        'so_luong',
        'thanh_tien',
        'ngay_tao',
        'trang_thai',
    ];

    public function doithecao()
    {
        return $this->belongsTo(DoithecaoDanhsach::class, 'doithecao_id', 'id_doithecao');
    }
}
