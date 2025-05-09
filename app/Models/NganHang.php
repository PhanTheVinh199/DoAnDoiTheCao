<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NganHang extends Model
{
    use HasFactory;

    // Đặt tên bảng
    protected $table = 'nganhang';

    // Đặt khóa chính
    protected $primaryKey = 'id_danhsach'; // nếu không phải "id"

    // Nếu bảng có các cột created_at và updated_at thì để true
    public $timestamps = true;

    // Các trường có thể mass-assigned
    protected $fillable = [
        'thanhvien_id',
        'ten_ngan_hang',
        'chu_tai_khoan',
        'so_tai_khoan',
        'trang_thai',
    ];

    // Mối quan hệ với bảng ThanhVien (mỗi ngân hàng có một thành viên)
    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }

    // Mối quan hệ với bảng RutTien (một ngân hàng có thể có nhiều lần rút tiền)
    public function ruttiens()
    {
        return $this->hasMany(RutTien::class, 'danhsach_id');
    }
}
