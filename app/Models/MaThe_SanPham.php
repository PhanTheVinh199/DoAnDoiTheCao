<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaThe_SanPham extends Model
{
    protected $table = 'mathecao_danhsach'; // Đổi đúng tên bảng nếu cần

    public $timestamps = false;
    
    protected $primaryKey = 'id_mathecao';

    protected $fillable = ['nhacungcap_id', 'menh_gia','chiet_khau','trang_thai'];

    // Thêm quan hệ với bảng nhà cung cấp
    public function nhacungcap()
    {
        return $this->belongsTo(MaThe_NhaCungCap::class, 'nhacungcap_id', 'id_nhacungcap');
    }
}
