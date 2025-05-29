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

    public static function getProducts($supplierId = 'all', $perPage = 10, $page = 1)
    {
        return self::when($supplierId !== 'all', function ($query) use ($supplierId) {
            return $query->where('nhacungcap_id', $supplierId);
        })
        ->orderBy('ngay_tao', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function createProduct(array $data)
    {
        $data['trang_thai'] = $data['trang_thai'] ?? 'hoat_dong';
        return self::create($data);
    }

    public static function updateProduct($id, array $data)
    {
        $product = self::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public static function deleteProduct($id)
    {
        $product = self::findOrFail($id);

        if ($product->hinhanh && File::exists(public_path($product->hinhanh))) {
            File::delete(public_path($product->hinhanh));
        }

        return $product->delete();
    }

    public static function getAllSuppliers()
    {
        return MaThe_NhaCungCap::all();
    }
    public static function getProductCount($supplierId)
{
    $query = self::query();

    if ($supplierId !== 'all') {
        $query->where('nhacungcap_id', $supplierId);
    }

    return $query->count();
}
}
