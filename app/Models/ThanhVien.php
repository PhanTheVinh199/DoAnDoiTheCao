<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\NganHang;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ThanhVien extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'thanhvien';
    protected $primaryKey = 'id_thanhvien';
    public $timestamps = true;  // Sử dụng timestamps (created_at, updated_at)

    protected $fillable = [
        'tai_khoan',
        'ho_ten',
        'phone',
        'email',
        'mat_khau',
        'so_du',
        'quyen',
        'id_thanhvien'
    ];

    protected $hidden = [
        'mat_khau', // Ẩn mật khẩu khi truy xuất
    ];

    // Phương thức để đăng nhập bằng 'tai_khoan' thay vì 'email'
    public function username()
    {
        return 'tai_khoan'; // Đăng nhập bằng tài khoản, nếu muốn có thể thay đổi sang 'email'
    }

    // Cấu hình lại tên trường để nhận diện của người dùng
    public function getAuthIdentifierName()
    {
        return $this->username(); // Đảm bảo lấy 'tai_khoan' khi đăng nhập
    }

    // Phương thức lấy mật khẩu đã mã hóa
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    // Quan hệ với bảng 'NganHang' - Một thành viên có thể có nhiều tài khoản ngân hàng
    public function nganHang()
    {
        return $this->hasMany(NganHang::class, 'thanhvien_id', 'id_thanhvien');
    }

    // Quan hệ với bảng 'RutTien' - Một thành viên có thể thực hiện nhiều giao dịch rút tiền
    public function ruttiens()
    {
        return $this->hasMany(RutTien::class, 'thanhvien_id');
    }

    // Quan hệ với bảng 'DoithecaoDonhang' - Một thành viên có thể có nhiều đơn hàng
    public function donhangs()
    {
        return $this->hasMany(DoithecaoDonhang::class, 'thanhvien_id');
    }

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu (đảm bảo tính bảo mật)
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            if ($model->mat_khau) {
                $model->mat_khau = Hash::make($model->mat_khau);
            }
        });

        static::updating(function ($model) {
            // Mã hóa mật khẩu khi cập nhật
            if ($model->mat_khau && $model->isDirty('mat_khau')) {
                $model->mat_khau = Hash::make($model->mat_khau);
            }
        });
    }
}
