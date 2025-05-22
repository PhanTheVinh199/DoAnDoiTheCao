<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MTC_NhaCungCap extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Viettel',
            'hinhanh' => 'images/the-viettel.png',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Vinaphone',
            'hinhanh' => 'images/the-vinaphone.jpeg',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Vietnamobile',
            'hinhanh' => 'images/the-vietnamobile.jpeg',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Mobifone',
            'hinhanh' => 'images/mobifone.png',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Zing',
            'hinhanh' => 'images/the-zing.png',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Garena',
            'hinhanh' => 'images/garena.png',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Appota',
            'hinhanh' => 'images/APPOTA_CARD.png',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Carot',
            'hinhanh' => 'images/the-ca-rot.jpg',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Funcard',
            'hinhanh' => 'images/the-funcard.jpg',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Scoin',
            'hinhanh' => 'images/the-scoin.jpg',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);

        DB::table('mathecao_nhacungcap')->insert([
            'ten' => 'Vcoin',
            'hinhanh' => 'images/the-vcoin.png',
            'ngay_tao' => $now,
            'ngay_cap_nhat' => $now,
            'trang_thai' => 'hoat_dong',
        ]);
    }
}
