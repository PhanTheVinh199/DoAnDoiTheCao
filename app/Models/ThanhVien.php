<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\NganHang;

//login vs register

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ThanhVien extends Authenticatable
{
    use Notifiable;

    protected $table = 'thanhvien';
    protected $primaryKey = 'id_thanhvien';
    public $timestamps = true;

    protected $fillable = [
        'tai_khoan',
        'ho_ten',
        'phone',
        'email',
        'mat_khau',
        'so_du',
        'quyen',
        'role',
    ];

    protected $hidden = [
        'mat_khau',
    ];

    public function username()
    {
        return 'tai_khoan'; // hoặc trả về 'email' nếu đăng nhập bằng email
    }

    public function getAuthIdentifierName()
    {
        return $this->username();
    }

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }
    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu


    // Ví dụ về phương thức quan hệ với NganHang (nếu có)
    public function nganHang()
    {
        return $this->hasMany(NganHang::class, 'thanhvien_id', 'id_thanhvien');
    }
    public function ruttiens()
    {
        return $this->hasMany(RutTien::class, 'thanhvien_id');
    }

    /**
     * Define role constants
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Get available roles
     */
    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_ADMIN => 'Quản trị viên',
            self::ROLE_USER => 'Người dùng',
        ];
    }

    /**
     * Set user as admin
     */
    public function setAsAdmin(): bool
    {
        return $this->update(['role' => self::ROLE_ADMIN]);
    }

    /**
     * Set user as regular user
     */
    public function setAsUser(): bool
    {
        return $this->update(['role' => self::ROLE_USER]);
    }

    /**
     * Scope a query to only include admin users
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    /**
     * Scope a query to only include regular users
     */
    public function scopeUsers($query)
    {
        return $query->where('role', self::ROLE_USER);
    }
}
