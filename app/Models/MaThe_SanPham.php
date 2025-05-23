<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class MaThe_SanPham extends Model
{
    protected $table = 'mathecao_danhsach';
    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';
    public $timestamps = true;
    protected $primaryKey = 'id_mathecao';

    protected $fillable = ['nhacungcap_id', 'menh_gia', 'chiet_khau', 'trang_thai', 'hinhanh'];

    public function nhacungcap()
    {
        return $this->belongsTo(MaThe_NhaCungCap::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    /**
     * Lấy danh sách sản phẩm, lọc theo nhà cung cấp, phân trang
     */
    public static function getProducts($supplierId = 'all', $perPage = 10, $page = 1)
    {
        return self::when($supplierId !== 'all', function ($query) use ($supplierId) {
            return $query->where('nhacungcap_id', $supplierId);
        })
        ->orderBy('ngay_tao', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Tạo sản phẩm mới
     */
    public static function createProduct(array $data)
    {
        // Mặc định trạng thái nếu không có
        $data['trang_thai'] = $data['trang_thai'] ?? 'hoat_dong';
        return self::create($data);
    }

    /**
     * Cập nhật sản phẩm theo ID
     */
    public static function updateProduct($id, array $data)
    {
        $product = self::findOrFail($id);
        $product->update($data);
        return $product;
    }

    /**
     * Xóa sản phẩm theo ID kèm xóa file ảnh nếu có
     */
    public static function deleteProduct($id)
    {
        $product = self::findOrFail($id);

        if ($product->hinhanh && File::exists(public_path($product->hinhanh))) {
            File::delete(public_path($product->hinhanh));
        }

        return $product->delete();
    }

    /**
     * Lấy tất cả nhà cung cấp để dùng cho select
     */
    public static function getAllSuppliers()
    {
        return MaThe_NhaCungCap::all();
    }
}
