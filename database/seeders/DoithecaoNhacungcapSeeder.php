<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoithecaoNhacungcapSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('doithecao_nhacungcap')->insert([
            [
                'ten' => 'Viettel',
                'hinh_anh' => 'viettel.png',
                'ngay_tao' => now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Mobifone',
                'hinh_anh' => 'mobifone.png',
                'ngay_tao' => now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Vinaphone',
                'hinh_anh' => 'vinaphone.png',
                'ngay_tao' => now(),
                'trang_thai' => 'hoat_dong',
            ],
        ]);
    }
}
