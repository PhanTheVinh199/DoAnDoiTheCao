<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NganhangAdmin;
use App\Models\ThanhVien;

class NganhangAdminSeeder extends Seeder
{
    public function run()
    {
        // Lấy 1 admin bất kỳ để gán thanhvien_id
        $admin = ThanhVien::where('quyen', 'admin')->first();

        if (!$admin) {
            $this->command->info('Không có admin nào trong bảng thanhvien, vui lòng tạo admin trước.');
            return;
        }

        for ($i = 1; $i <= 50; $i++) {
            NganhangAdmin::create([
                'thanhvien_id' => $admin->id_thanhvien,
                'ten_ngan_hang' => 'Mbbank ' . $i,
                'so_tai_khoan' => '12345' . $i,
                'chu_tai_khoan' => 'NGUYEN VAN BAO ' . $i,
                'trang_thai' => 'hoat_dong',
            ]);
        }

        // $this->command->info('Đã tạo xong 10 ngân hàng admin mẫu.');
    }
}
