<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaThe_DonHang extends Model
{
    protected $table = 'mathecao_donhang'; // Đổi đúng tên bảng nếu cần

    public $timestamps = false;
    
    protected $primaryKey = 'id_donbanthe';

    protected $fillable = ['ma_don', 'mathecao_id','so_luong','thanhvien_id','trang_thai'];

    // Thêm quan hệ với bảng nhà cung cấp
    public function sanPham()
    {
        return $this->belongsTo(MaThe_SanPham::class, 'mathecao_id', 'id_mathecao');
    }
    public function ThanhVien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }
    public function nhacungcap()
    {
        return $this->belongsTo(MaThe_NhaCungCap::class, 'nhacungcap_id', 'id_nhacungcap');
    }
}
