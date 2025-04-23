<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaThe_NhaCungCap;
use Illuminate\Support\Facades\DB;


class MTC_NhaCungCap extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Viettel',
            'hinhanh' => 'images/the-viettel.png',
            'ngay_tao' => now(),
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Vinaphone',
            'hinhanh' => 'images/the-vinaphone.jpeg',
            'ngay_tao' => now(),
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Vietnamobile',
            'hinhanh' => 'images/the-vietnamobile.jpeg',
            'ngay_tao' => now(),
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Mobifone',
            'hinhanh' => 'images/mobifone.png',
            'ngay_tao' => now(),
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Zing',
            'hinhanh' => 'images/the-zing.png',
            'ngay_tao' => now(),
            'trang_thai' => 'hoat_dong',
        ]);
    }
}
