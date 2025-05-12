<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NapTien extends Model
{
    use HasFactory;

    // Đặt tên bảng (nếu khác tên mặc định)
    protected $table = 'lichsu_nap';
    protected $primaryKey = 'id_lichsunap';

    // Các trường có thể gán giá trị (mass assignment)
    protected $fillable = [
        'ma_don',
        'thanhvien_id',
        'so_tien_nap',
        'noi_dung',
        'ngay_tao',
        'trang_thai',
        'paygate_code',
        'transfer_note', 
    ];

    // Định nghĩa quan hệ (nếu có)
    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }
    public function nganhang()
    {
        return $this->belongsTo(NganHang::class, 'paygate_code', 'id_danhsach');
    }
}