<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NganHang extends Model
{
    use HasFactory;

    protected $table = 'nganhang';
    protected $primaryKey = 'id_danhsach';
    public $timestamps = true;

    protected $fillable = [
        'thanhvien_id',
        'ten_ngan_hang',
        'chu_tai_khoan',
        'so_tai_khoan',
        'trang_thai',
    ];

    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }

    public function ruttiens()
    {
        return $this->hasMany(RutTien::class, 'danhsach_id');
    }

    /**
     * Lấy danh sách ngân hàng có tìm kiếm và phân trang
     */
    public static function getBanks($search = null, $perPage = 5)
    {
        $query = self::with('thanhvien');

        if ($search) {
            $query->whereHas('thanhvien', function ($q) use ($search) {
                $q->where('tai_khoan', 'like', "%{$search}%")
                  ->orWhere('so_tai_khoan', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'asc')->paginate($perPage);
    }

    /**
     * Xóa ngân hàng theo id
     */
    public static function deleteBank($id)
    {
        $bank = self::findOrFail($id);
        return $bank->delete();
    }

    /**
     * Tạo ngân hàng mới, tự động tìm thanh vien theo tài khoản
     */
    public static function createBank(array $data)
    {
        // Tìm thành viên theo tên tài khoản
        $thanhvien = \App\Models\ThanhVien::where('tai_khoan', $data['ten_thanhvien'])->first();

        if (!$thanhvien) {
            throw new \Exception("Không tìm thấy thành viên: " . $data['ten_thanhvien']);
        }

        // Chuẩn bị data lưu
        $saveData = [
            'thanhvien_id' => $thanhvien->id_thanhvien,
            'ten_ngan_hang' => $data['ten_ngan_hang'],
            'so_tai_khoan' => $data['so_tai_khoan'],
            'chu_tai_khoan' => $data['chu_tai_khoan'],
            'trang_thai' => $data['trang_thai'] ?? true,
        ];

        return self::create($saveData);
    }

    /**
     * Cập nhật thông tin rút tiền
     */
    public static function updateRutTien($id, array $data)
    {
        $rutTien = \App\Models\RutTien::findOrFail($id);
        $rutTien->update($data);
        return $rutTien;
    }

    /**
     * Xóa lịch sử rút tiền
     */
    public static function deleteRutTien($id)
    {
        $rutTien = \App\Models\RutTien::findOrFail($id);
        return $rutTien->delete();
    }

    /**
     * Lấy danh sách rút tiền có phân trang và tìm kiếm
     */
    public static function getRutTiens($search = null, $perPage = 5)
    {
        $query = \App\Models\RutTien::with(['thanhvien', 'nganhang']);

        if ($search) {
            $query->where('ma_don', 'like', "%{$search}%");
        }

        return $query->orderBy('created_at', 'asc')->paginate($perPage);
    }

    /**
     * Lấy danh sách nạp tiền có tìm kiếm và phân trang
     */
    public static function getNapTiens($search = null, $perPage = 5)
    {
        $query = \App\Models\NapTien::query();

        if ($search) {
            $query->where('ma_don', 'like', "%{$search}%");
        }

        return $query->orderBy('created_at', 'asc')->paginate($perPage);
    }

    /**
     * Cập nhật nạp tiền
     */
    public static function updateNapTien($id, array $data)
    {
        $napTien = \App\Models\NapTien::findOrFail($id);
        $napTien->update($data);
        return $napTien;
    }

    /**
     * Xóa nạp tiền
     */
    public static function deleteNapTien($id)
    {
        $napTien = \App\Models\NapTien::findOrFail($id);
        return $napTien->delete();
    }
}
