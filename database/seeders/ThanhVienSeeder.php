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

        // Hàm để tạo tên hợp lệ chỉ gồm chữ cái có dấu và dấu cách
        function generateValidName($faker) {
            do {
                // Tạo tên bình thường
                $name = $faker->name;
                // Loại bỏ các ký tự không phải chữ cái tiếng Việt và dấu cách
                // Chỉ giữ chữ cái tiếng Việt, dấu cách (regex phù hợp Unicode)
                $valid = preg_match('/^[\p{L} ]+$/u', $name);
            } while (!$valid);
            return $name;
        }

        // Hàm tạo số điện thoại bắt đầu bằng 0, 10 chữ số
        function generatePhoneNumber() {
            $number = '0';
            for ($i = 0; $i < 9; $i++) {
                $number .= mt_rand(0, 9);
            }
            return $number;
        }

        // Tạo tài khoản admin mặc định đầu tiên
        ThanhVien::create([
            'ho_ten' => 'NGUYEN THANH TU',
            'tai_khoan' => 'admin123',
            'mat_khau' => bcrypt('123456'), // mật khẩu là 123456
            'email' => 'admin@gmail.com',
            'phone' => generatePhoneNumber(),
            'so_du' => 1000000, // số dư cố định hoặc tùy chỉnh
            'quyen' => 'admin',
        ]);

        // Tạo 20 tài khoản demo ngẫu nhiên tiếp theo
        for ($i = 1; $i <= 20; $i++) {
            ThanhVien::create([
                'ho_ten' => generateValidName($faker),
                'tai_khoan' => 'thanhvien' . ($i + 1),
                'mat_khau' => bcrypt('password' . ($i + 1)),
                'email' => $faker->unique()->safeEmail,
                'phone' => generatePhoneNumber(),
                'so_du' => $faker->numberBetween(1000, 10000),
                'quyen' => $faker->randomElement(['admin', 'user']),
            ]);
        }
    }
}
