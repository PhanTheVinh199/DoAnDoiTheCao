<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoithecaoDanhsach extends Model
{
    // Tên bảng nếu khác với chuẩn Laravel
    protected $table = 'doithecao_danhsach';

    // Khóa chính
    protected $primaryKey = 'id_doithecao';

    // Nếu không dùng auto-increment
    public $incrementing = true;

    // Kiểu của khóa chính
    protected $keyType = 'int';

    // Cho phép tự động timestamps
    public $timestamps = false;

    // Danh sách fillable để sử dụng mass assignment
    protected $fillable = [
        'nhacungcap_id',
        'menh_gia',
        'chiet_khau',
        'trang_thai',
        'hinh_anh'
    ];

    // Quan hệ: Mỗi thẻ thuộc về một nhà cung cấp
    public function nhacungcap()
    {
        return $this->belongsTo(DoithecaoNhacungcap::class, 'nhacungcap_id', 'id_nhacungcap');
    }

    // ✅ Getter: Trả về chuỗi hiển thị của trạng thái
    public function getTrangThaiTextAttribute()
    {
        return match ($this->trang_thai) {
            'hoat_dong' => 'Hoạt Động',
            'da_huy' => 'Đã Hủy',
            'cho_xu_ly' => 'Chờ Xử Lý',
            default => 'Không xác định'
        };
    }

    // ✅ Getter: Trả về class Bootstrap tương ứng
    public function getTrangThaiClassAttribute()
    {
        return match ($this->trang_thai) {
            'hoat_dong' => 'success',
            'da_huy' => 'danger',
            'cho_xu_ly' => 'warning',
            default => 'secondary'
        };
    }
}