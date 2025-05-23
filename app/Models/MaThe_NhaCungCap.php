<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class MaThe_NhaCungCap extends Model
{
    protected $table = 'mathecao_nhacungcap';
    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';
    public $timestamps = true;
    protected $primaryKey = 'id_nhacungcap';

    protected $fillable = ['ten', 'hinhanh', 'trang_thai'];

    public function sanpham()
    {
        return $this->hasMany(MaThe_SanPham::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    protected static $uploadPath = 'uploads';

    /**
     * Upload file ảnh, trả về đường dẫn lưu ảnh hoặc null
     */
    public static function uploadImage($file)
    {
        if (!$file) return null;

        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $uploadDir = public_path(self::$uploadPath);

        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0777, true);
        }

        $file->move($uploadDir, $fileName);
        return self::$uploadPath . '/' . $fileName;
    }

    /**
     * Tạo nhà cung cấp mới kèm upload ảnh
     */
    public static function createSupplier(array $data, $imageFile = null)
    {
        if ($imageFile) {
            $data['hinhanh'] = self::uploadImage($imageFile);
        }
        $data['trang_thai'] = $data['trang_thai'] ?? 'hoat_dong';
        return self::create($data);
    }

    /**
     * Cập nhật nhà cung cấp kèm upload ảnh mới (nếu có), xóa ảnh cũ
     */
    public static function updateSupplier($id, array $data, $imageFile = null)
    {
        $supplier = self::findOrFail($id);

        if ($imageFile) {
            if ($supplier->hinhanh && File::exists(public_path($supplier->hinhanh))) {
                File::delete(public_path($supplier->hinhanh));
            }
            $data['hinhanh'] = self::uploadImage($imageFile);
        }

        $supplier->fill($data);
        $supplier->save();

        return $supplier;
    }

    /**
     * Xóa nhà cung cấp và xóa ảnh liên quan
     */
    public static function deleteSupplier($id)
    {
        $supplier = self::findOrFail($id);

        if ($supplier->hinhanh && File::exists(public_path($supplier->hinhanh))) {
            File::delete(public_path($supplier->hinhanh));
        }

        return $supplier->delete();
    }
}
