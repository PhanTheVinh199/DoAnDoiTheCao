<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThanhVien;
use Faker\Factory as Faker;

class ThanhVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(); // Sử dụng Faker để tạo dữ liệu giả

        // Tạo 10 tài khoản demo
        for ($i = 0; $i < 10; $i++) {
            ThanhVien::create([
                'ho_ten' => $faker->name,
                'tai_khoan' => 'thanhvien' . ($i + 1),
                'mat_khau' => bcrypt('password' . ($i + 1)), // Sử dụng bcrypt để mã hóa mật khẩu
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'so_du' => $faker->numberBetween(1000, 10000), // Số dư ngẫu nhiên
                'quyen' => $faker->randomElement(['admin', 'user']), // Chọn ngẫu nhiên quyền
            ]);
        }
    }
}
