<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ThanhvienSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('thanhvien')->insert([
            [
                'ho_ten' => 'Nguyễn Văn A',
                'tai_khoan' => 'nguyenvana',
                'email' => 'a@example.com',
                'phone' => '0911111111',
                'so_du' => 100000,
                'quyen' => 'user',
            ],
            [
                'ho_ten' => 'Admin',
                'tai_khoan' => 'admin',
                'email' => 'admin@example.com',
                'phone' => '0999999999',
                'so_du' => 500000,
                'quyen' => 'admin',
            ]
        ]);
    }
}
