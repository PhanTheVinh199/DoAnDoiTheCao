<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\ThanhVien; // Thêm dòng này

class ThanhVien extends Model
{
    use HasFactory;

    protected $table = 'thanhvien';
    protected $primaryKey = 'id_thanhvien';
    public $timestamps = true;

    protected $fillable = [
        'ho_ten', 'tai_khoan', 'mat_khau', 'email', 'phone', 'so_du', 'quyen'
    ];

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    public static function boot()
    {
        parent::boot();

        static::saving(function ($thanhvien) {
            if ($thanhvien->isDirty('mat_khau')) {
                $thanhvien->mat_khau = Hash::make($thanhvien->mat_khau); // Mã hóa mật khẩu
            }
        });
    }

    // Ví dụ về phương thức quan hệ với NganHang (nếu có)
    public function nganHang()
    {
        return $this->hasMany(NganHang::class, 'thanhvien_id', 'id_thanhvien');
    }
    public function ruttiens()
{
    return $this->hasMany(RutTien::class, 'thanhvien_id');
}

}
