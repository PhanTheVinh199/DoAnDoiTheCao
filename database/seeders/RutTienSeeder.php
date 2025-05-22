<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RutTien;
use App\Models\ThanhVien;
use App\Models\NganHang;
use Illuminate\Support\Str;

class RutTienSeeder extends Seeder
{
    public function run()
    {
        // Tạo 10 bản ghi lịch sử rút tiền
        for ($i = 1; $i <= 21; $i++) {
            $thanhvien = ThanhVien::inRandomOrder()->first(); // Lấy ngẫu nhiên thành viên
            $nganhang = NganHang::inRandomOrder()->first(); // Lấy ngẫu nhiên ngân hàng

            RutTien::create([
                'ma_don' => 'ruttien_' . Str::random(10), // Mã đơn ngẫu nhiên
                'thanhvien_id' => $thanhvien->id_thanhvien, // ID thành viên
                'danhsach_id' => $nganhang->id_danhsach, // ID ngân hàng
                'so_tien_rut' => rand(100000, 1000000), // Số tiền rút ngẫu nhiên
                'trang_thai' => 'cho_duyet', // Trạng thái mặc định
            ]);
        }
    }
}
