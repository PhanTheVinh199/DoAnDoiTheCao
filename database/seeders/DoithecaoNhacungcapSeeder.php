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
                'hinh_anh' => 'images/mobifone.png',
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
                'ten' => 'Vietnamobile',
                'hinhanh' => 'images/the-vietnamobile.jpeg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Garena',
                'hinhanh' => 'images/garena.png',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],

            [
                'ten' => 'Appota',
                'hinhanh' => 'images/APPOTA_CARD.png',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],

            [
                'ten' => 'Carot',
                'hinhanh' => 'images/the-ca-rot.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Funcard',
                'hinhanh' => 'images/the-funcard.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Scoin',
                'hinhanh' => 'images/the-scoin.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Vcoin',
                'hinhanh' => 'images/the-vcoin.png',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ]
        ]);
    }
}
