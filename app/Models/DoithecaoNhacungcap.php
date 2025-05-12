<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoithecaoNhacungcap extends Model
{
    use HasFactory;

    // Bảng tương ứng trong database
    protected $table = 'doithecao_nhacungcap';

    // Khóa chính nếu không phải là 'id'
    protected $primaryKey = 'id_nhacungcap';

    // Tắt timestamps nếu bảng không có cột created_at, updated_at
    public $timestamps = false;

    public function getRouteKeyName()
{
    return 'id_nhacungcap';
}


    // Những cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'ten',
        'hinh_anh',
        'ngay_tao',
        'trang_thai'
    ];

     // Quan hệ với bảng DoithecaoDanhsach
    public function danhsach()
    {
        return $this->hasMany(DoithecaoDanhsach::class, 'nhacungcap_id', 'id_nhacungcap');
    }
}
