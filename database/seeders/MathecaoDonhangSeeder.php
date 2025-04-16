<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MathecaoDonhangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD001',
            'mathecao_id' => 1, // ID của thẻ cào trong bảng mathecao_danhsach
            'so_luong' => 2,
            'thanh_tien' => 100000,
            'thanhvien_id' => 1, // ID thành viên có sẵn trong bảng thanhvien
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);

        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD002',
            'mathecao_id' => 1, // ID của thẻ cào trong bảng mathecao_danhsach
            'so_luong' => 5,
            'thanh_tien' => 0,
            'thanhvien_id' => 11, // ID thành viên có sẵn trong bảng thanhvien
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);
    }
}
