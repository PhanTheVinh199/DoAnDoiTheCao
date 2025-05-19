<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaThe_DonHang extends Model
{
    protected $table = 'mathecao_donhang';
    public $timestamps = false;
    protected $primaryKey = 'id_donbanthe';

    protected $fillable = [
        'ma_don',
        'mathecao_id',
        'so_luong',
        'thanh_tien',
        'thanhvien_id',
        'trang_thai',
    ];

    public function sanpham()
    {
        return $this->belongsTo(MaThe_SanPham::class, 'mathecao_id', 'id_mathecao');
    }

    public function thanhvien()
    {
        return $this->belongsTo(ThanhVien::class, 'thanhvien_id', 'id_thanhvien');
    }

    public function nhacungcap()
    {
        return $this->belongsTo(MaThe_NhaCungCap::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    /**
     * Lấy danh sách đơn hàng có lọc tìm kiếm theo mã đơn, phân trang
     */
    public static function getOrders($searchTerm = '', $perPage = 10)
    {
        $query = self::with('sanpham.nhacungcap');

        if ($searchTerm) {
            $query->where('ma_don', 'like', '%' . $searchTerm . '%');
        }

        return $query->orderBy('ngay_tao', 'desc')->paginate($perPage);
    }

    /**
     * Tạo đơn hàng mới, tự tính thành tiền dựa trên sản phẩm
     */
    public static function createOrder(array $data)
    {
        $sanPham = MaThe_SanPham::findOrFail($data['mathecao_id']);
        $menhGia = $sanPham->menh_gia;
        $chietKhau = $sanPham->chiet_khau;

        $data['thanh_tien'] = $data['so_luong'] * $menhGia * (1 - $chietKhau / 100);

        return self::create($data);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public static function updateStatus($id, $trang_thai)
    {
        $donHang = self::findOrFail($id);
        $donHang->trang_thai = $trang_thai;
        $donHang->save();

        return $donHang;
    }

    /**
     * Xóa đơn hàng
     */
    public static function deleteOrder($id)
    {
        $donHang = self::findOrFail($id);
        return $donHang->delete();
    }
}
