<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThanhVien;
use Faker\Factory as Faker;

class ThanhVienSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Tạo tài khoản admin mặc định đầu tiên
        ThanhVien::create([
            'ho_ten' => 'NGUYEN VAN BAO',
            'tai_khoan' => 'admin123',
            'mat_khau' => bcrypt('123456'), // mật khẩu là 123456
            'email' => 'admin@gmail.com',
            'phone' => $faker->phoneNumber,
            'so_du' => 1000000, // số dư cố định hoặc tùy chỉnh
            'quyen' => 'admin',
        ]);

        // Tạo 20 tài khoản demo ngẫu nhiên tiếp theo
        for ($i = 1; $i < 21; $i++) {
            ThanhVien::create([
                'ho_ten' => $faker->name,
                'tai_khoan' => 'thanhvien' . ($i + 1),
                'mat_khau' => bcrypt('password' . ($i + 1)),
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'so_du' => $faker->numberBetween(1000, 10000),
                'quyen' => $faker->randomElement(['admin', 'user']),
            ]);
        }
    }
}
