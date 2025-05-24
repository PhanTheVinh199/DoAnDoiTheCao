<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoithecaoDanhsach extends Model
{
    use HasFactory;

    protected $table = 'doithecao_danhsach';
    protected $primaryKey = 'id_doithecao';
    public $timestamps = true;

    protected $fillable = [
        'nhacungcap_id',
        'menh_gia',
        'chiet_khau',
        'trang_thai',
        'hinh_anh'
    ];

    public function nhacungcap()
    {
        return $this->belongsTo(DoithecaoNhacungcap::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    public function getTrangThaiTextAttribute()
    {
        return match ($this->trang_thai) {
            1 => 'Hoạt Động',
            0 => 'Đã Hủy',
            2 => 'Chờ Xử Lý',
            default => 'Không xác định'
        };
    }

    public function getTrangThaiClassAttribute()
    {
        return match ($this->trang_thai) {
            1 => 'success',
            0 => 'danger',
            2 => 'warning',
            default => 'secondary'
        };
    }

    public function getThanhTienSauChietKhauAttribute()
    {
        $thanhTien = $this->menh_gia * $this->so_luong;
        $chietKhau = $thanhTien * ($this->chiet_khau / 100);
        return $thanhTien - $chietKhau;
    }

    // ========== XỬ LÝ LẤY DỮ LIỆU ==========

    public static function getAllWithSupplier()
    {
        return self::with('nhacungcap')->get();
    }

    public static function getNewestSupplier()
    {
        return DoithecaoNhacungcap::orderBy('ngay_tao', 'desc')->first();
    }

    public static function getAllSuppliers()
    {
        return DoithecaoNhacungcap::all();
    }

    // ========== XỬ LÝ THÊM MỚI ==========

    public static function createProduct(array $data)
    {
        $statusMap = [
            'hoat_dong' => 1,
            'da_huy' => 0,
            'cho_xu_ly' => 2,
        ];
        $data['trang_thai'] = $statusMap[$data['trang_thai']] ?? 0;

        return self::create($data);
    }

    // ========== XỬ LÝ CẬP NHẬT ==========

    public static function updateProduct($id, array $data)
    {
        $statusMap = [
            'hoat_dong' => 1,
            'da_huy' => 0,
            'cho_xu_ly' => 2,
        ];
        $data['trang_thai'] = $statusMap[$data['trang_thai']] ?? 0;

        $product = self::findOrFail($id);
        $product->update($data);

        return $product;
    }

    // ========== XỬ LÝ XÓA ==========

    public static function deleteProduct($id)
    {
        $product = self::findOrFail($id);
        return $product->delete();
    }
}
