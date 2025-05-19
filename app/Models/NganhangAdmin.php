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

    /**
     * Lấy danh sách ngân hàng với tùy chọn tìm kiếm và phân trang
     */
    public static function getBanks($search = null, $perPage = 5)
    {
        $query = self::with('thanhvien');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ten_ngan_hang', 'like', "%{$search}%")
                  ->orWhere('so_tai_khoan', 'like', "%{$search}%")
                  ->orWhere('chu_tai_khoan', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Tạo mới ngân hàng
     */
    public static function createBank(array $data)
    {
        return self::create($data);
    }

    /**
     * Xóa ngân hàng theo id
     */
    public static function deleteBank($id)
    {
        $bank = self::findOrFail($id);
        return $bank->delete();
    }
}
