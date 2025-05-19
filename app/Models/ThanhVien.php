<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    // --- PHẦN XỬ LÝ NGHIỆP VỤ ---

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
     * Cập nhật thông tin thành viên, nếu có mật khẩu thì mã hóa
     */
    public static function updateMember($id, array $data)
    {
        $member = self::findOrFail($id);

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
     * Xóa thành viên
     */
    public static function deleteMember($id)
    {
        $member = self::findOrFail($id);
        return $member->delete();
    }

    /**
     * Cộng hoặc trừ tiền vào tài khoản thành viên
     * $amount dương là cộng, âm là trừ
     */
    public function adjustBalance($amount)
    {
        $this->so_du += $amount;

        if ($this->so_du < 0) {
            throw new \Exception('Số dư không đủ');
        }

        $this->save();

        return $this;
    }
}
