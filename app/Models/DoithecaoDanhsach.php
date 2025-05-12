<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoithecaoDanhsach extends Model
{
    use HasFactory;

    protected $table = 'doithecao_danhsach';
    protected $primaryKey = 'id_doithecao';
    public $timestamps = false;

    protected $fillable = [
        'nhacungcap_id',
        'menh_gia',
        'chiet_khau',
        'trang_thai',
        'hinh_anh'
    ];

    /**
     * Quan hệ với bảng DoithecaoNhacungcap.
     * Mỗi sản phẩm sẽ liên kết với 1 nhà cung cấp.
     */
    public function nhacungcap()
    {
        return $this->belongsTo(DoithecaoNhacungcap::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    /**
     * Getter: Trả về trạng thái dưới dạng chuỗi
     */
    public function getTrangThaiTextAttribute()
    {
        return match ($this->trang_thai) {
            'hoat_dong' => 'Hoạt Động',
            'da_huy' => 'Đã Hủy',
            'cho_xu_ly' => 'Chờ Xử Lý',
            default => 'Không xác định'
        };
    }

    /**
     * Getter: Trả về class Bootstrap tương ứng với trạng thái
     */
    public function getTrangThaiClassAttribute()
    {
        return match ($this->trang_thai) {
            'hoat_dong' => 'success',
            'da_huy' => 'danger',
            'cho_xu_ly' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Tính thành tiền sau chiết khấu
     */
    public function getThanhTienSauChietKhauAttribute()
    {
        $thanhTien = $this->menh_gia * $this->so_luong;
        $chietKhau = $thanhTien * ($this->chiet_khau / 100);
        return $thanhTien - $chietKhau;
    }
}
