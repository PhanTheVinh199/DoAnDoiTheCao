<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MTC_DonHang extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD001',
            'mathecao_id' => 1, 
            'so_luong' => 5,
            'thanh_tien' => 0,
            'thanhvien_id' => 1, 
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);

        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD002',
            'mathecao_id' => 11, 
            'so_luong' => 4,
            'thanh_tien' => 0,
            'thanhvien_id' => 11, 
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);
        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD003',
            'mathecao_id' => 18, 
            'so_luong' => 5,
            'thanh_tien' => 0,
            'thanhvien_id' => 11, 
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);
        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD004',
            'mathecao_id' => 20, 
            'so_luong' => 10,
            'thanh_tien' => 0,
            'thanhvien_id' => 11, 
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);
        DB::table('mathecao_donhang')->insert([
            'ma_don' => 'MD005',
            'mathecao_id' => 27, 
            'so_luong' => 1,
            'thanh_tien' => 0,
            'thanhvien_id' => 11, 
            'ngay_tao' => now(),
            'trang_thai' => 'Chờ xử lý',
        ]);
    }
}
