<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NganhangAdmin extends Model
{
    use HasFactory;

    protected $table = 'nganhang_admin';
    protected $primaryKey = 'id_danhsach';

    protected $fillable = [
        'thanhvien_id',
        'ten_ngan_hang',
        'so_tai_khoan',
        'chu_tai_khoan',
        'trang_thai',
    ];

    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }
}
