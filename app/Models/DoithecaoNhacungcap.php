<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class DoithecaoNhacungcap extends Model
{
    use HasFactory;

    protected $table = 'doithecao_nhacungcap';
    protected $primaryKey = 'id_nhacungcap';
    public $timestamps = true;

    protected $fillable = [
        'ten',
        'hinh_anh',
        'ngay_tao',
        'trang_thai'
    ];

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'updated_at';

    public function getRouteKeyName()
    {
        return 'id_nhacungcap';
    }

    public function danhsach()
    {
        return $this->hasMany(DoithecaoDanhsach::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    // Đường dẫn upload ảnh
    protected static $uploadPath = 'uploads/nhacungcap';

    /**
     * Upload ảnh và trả về đường dẫn lưu ảnh hoặc null
     */
    public static function uploadImage($file)
    {
        if (!$file) return null;

        $fileName = time() . '_' . $file->getClientOriginalName();
        $uploadDir = public_path(self::$uploadPath);

        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0777, true);
        }

        $file->move($uploadDir, $fileName);

        return self::$uploadPath . '/' . $fileName;
    }

    /**
     * Tạo nhà cung cấp mới với upload ảnh
     */
    public static function createSupplier(array $data, $imageFile = null)
    {
        if ($imageFile) {
            $data['hinh_anh'] = self::uploadImage($imageFile);
        }

        $data['trang_thai'] = 'hoat_dong';

        return self::create($data);
    }

    /**
     * Cập nhật nhà cung cấp kèm upload ảnh mới (nếu có)
     */
    public static function updateSupplier($id, array $data, $imageFile = null)
    {
        $supplier = self::findOrFail($id);

        if ($imageFile) {
            // Xóa ảnh cũ
            if ($supplier->hinh_anh && File::exists(public_path($supplier->hinh_anh))) {
                File::delete(public_path($supplier->hinh_anh));
            }
            $data['hinh_anh'] = self::uploadImage($imageFile);
        }

        $supplier->fill($data);
        $supplier->save();

        return $supplier;
    }

    /**
     * Xóa nhà cung cấp và file ảnh liên quan
     */
    public static function deleteSupplier($id)
    {
        $supplier = self::findOrFail($id);

        if ($supplier->hinh_anh && File::exists(public_path($supplier->hinh_anh))) {
            File::delete(public_path($supplier->hinh_anh));
        }

        return $supplier->delete();
    }

    /**
     * Ẩn nhà cung cấp
     */
    public static function hideSupplier($id)
    {
        $supplier = self::findOrFail($id);
        $supplier->trang_thai = 'an';
        $supplier->save();

        return $supplier;
    }

    /**
     * Hiện nhà cung cấp
     */
    public static function showSupplier($id)
    {
        $supplier = self::findOrFail($id);
        $supplier->trang_thai = 'hoat_dong';
        $supplier->save();

        return $supplier;
    }
}
