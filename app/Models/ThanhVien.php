<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ThanhVien extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'quyen'
    ];

    protected $hidden = [
        'mat_khau',
    ];

    public function username()
    {
        return 'tai_khoan';
    }

    public function getAuthIdentifierName()
    {
        return $this->username();
    }

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function nganHang()
    {
        return $this->hasMany(NganHang::class, 'thanhvien_id', 'id_thanhvien');
    }

    public function ruttiens()
    {
        return $this->hasMany(RutTien::class, 'thanhvien_id');
    }

    /**
     * Tìm và lọc thành viên có phân trang, tìm kiếm
     */
    public static function getThanhVienWithSearch($search = null, $perPage = 5)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tai_khoan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'asc')->paginate($perPage);
    }

    /**
     * Cập nhật thông tin thành viên, kiểm tra unique tai_khoan và email, mã hóa mật khẩu nếu có
     */
    public static function updateMember($id, array $data)
    {
        $member = self::find($id);
        if (!$member) {
            return null;
        }

        // Kiểm tra unique tai_khoan
        if (isset($data['tai_khoan'])) {
            $exists = self::where('tai_khoan', $data['tai_khoan'])
                ->where('id_thanhvien', '!=', $id)
                ->exists();
            if ($exists) {
                throw new \Exception('Tài khoản đã tồn tại.');
            }
        }

        // Kiểm tra unique email nếu có
        if (!empty($data['email'])) {
            $exists = self::where('email', $data['email'])
                ->where('id_thanhvien', '!=', $id)
                ->exists();
            if ($exists) {
                throw new \Exception('Email đã tồn tại.');
            }
        }

        $member->ho_ten = $data['ho_ten'] ?? $member->ho_ten;
        $member->tai_khoan = $data['tai_khoan'] ?? $member->tai_khoan;
        $member->email = $data['email'] ?? $member->email;
        $member->phone = $data['phone'] ?? $member->phone;
        $member->quyen = $data['quyen'] ?? $member->quyen;

        if (!empty($data['mat_khau'])) {
            $member->mat_khau = Hash::make($data['mat_khau']);
        }

        $member->save();

        return $member;
    }

    /**
     * Xóa thành viên, trả về true nếu thành công, false nếu thất bại
     */
    public static function deleteMember($id)
    {
        $member = self::find($id);
        if (!$member) {
            return false;
        }
        return $member->delete();
    }

    /**
     * Cộng hoặc trừ tiền vào tài khoản thành viên, dùng transaction + lock để tránh lỗi race condition
     * $amount dương là cộng, âm là trừ
     */
    public function adjustBalance($amount)
    {
        return DB::transaction(function () use ($amount) {
            // Khóa bản ghi để tránh xung đột
            $thanhvien = self::where('id_thanhvien', $this->id_thanhvien)->lockForUpdate()->first();

            if (!$thanhvien) {
                throw new \Exception('Thành viên không tồn tại');
            }

            $newBalance = $thanhvien->so_du + $amount;

            if ($newBalance < 0) {
                throw new \Exception('Số dư không đủ');
            }

            $thanhvien->so_du = $newBalance;
            $thanhvien->save();

            return $thanhvien;
        });
    }
}
