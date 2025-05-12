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
                'hinh_anh' => 'viettel.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Vinaphone',
                'hinh_anh' => 'vinaphone.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Mobifone',
                'hinh_anh' => 'mobifone.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Zing',
                'hinh_anh' => 'zing.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
            [
                'ten' => 'Appota',
                'hinh_anh' => 'appota.jpg',
                'ngay_tao' => Carbon::now(),
                'trang_thai' => 'hoat_dong',
            ],
        ]);
    }
}
