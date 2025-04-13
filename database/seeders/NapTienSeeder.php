<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NapTien;
use Carbon\Carbon;

class NapTienSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            NapTien::create([
                'ma_don' => 'naptien_0' . $i,  // Tạo mã đơn nạp tiền
                'thanhvien_id' => rand(1, 10),  // Giả sử bạn có 10 thành viên
                'so_tien_nap' => rand(50000, 500000),  // Giả sử số tiền từ 50.000 đến 500.000
                'noi_dung' => 'Nạp tiền vào tài khoản số ' . rand(100000, 999999),
                'ngay_tao' => Carbon::now(),
                'trang_thai' => ['cho_duyet', 'da_duyet', 'huy'][rand(0, 2)],
            ]);
        }
    }
}
