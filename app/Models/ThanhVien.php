<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ThanhVien extends Authenticatable
{
    use Notifiable;

    protected $table = 'thanhvien';
    protected $primaryKey = 'id_thanhvien';
    public $timestamps = false;

    protected $fillable = [
        'tai_khoan',
        'ho_ten',
        'phone',
        'email',
        'mat_khau',
        'so_du',
        'quyen'
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
}
