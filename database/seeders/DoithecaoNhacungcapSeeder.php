<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoithecaoNhacungcapSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng doithecao_nhacungcap
        DB::table('doithecao_nhacungcap')->insert([
            [
                'ten' => 'Viettel',
                'hinh_anh' => 'images/the-viettel.png',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Vinaphone',
                'hinh_anh' => 'images/the-vinaphone.jpeg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Mobifone',
                'hinh_anh' => 'images/the-mobifone.jpeg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Zing',
                'hinh_anh' => 'images/the-zing.png',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Appota',
                'hinh_anh' => 'images/APPOTA_CARD.png',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ]
        ]);
    }
}
