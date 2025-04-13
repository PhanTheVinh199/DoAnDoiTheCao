<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NganHang; // Thêm dòng này

class NganHang extends Model
{
    use HasFactory;

    protected $table = 'nganhang';

    protected $primaryKey = 'id_danhsach'; // nếu không phải "id"

    public $timestamps = true; // hoặc false nếu bảng không có created_at, updated_at

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
        public function ruttiens()
{
    return $this->hasMany(RutTien::class, 'danhsach_id');
}
}