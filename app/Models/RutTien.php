<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutTien extends Model
{
    use HasFactory;

    protected $table = 'lichsu_rut'; // Bảng tương ứng
    protected $primaryKey = 'id_lichsurut'; // Nếu không phải "id"
    public $timestamps = true; // Bật timestamps, Laravel sẽ tự động quản lý created_at và updated_at

    // Các trường cần thiết
    protected $fillable = [
        'ma_don', 'thanhvien_id', 'danhsach_id', 'so_tien_rut', 'trang_thai', 'created_at', 'updated_at'
    ];

    // Quan hệ với bảng NganHang
    public function nganhang()
    {
        return $this->belongsTo(NganHang::class, 'danhsach_id');
    }

    // Quan hệ với bảng ThanhVien
    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id');
    }
}
