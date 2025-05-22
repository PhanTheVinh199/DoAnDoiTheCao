<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MTC_SanPham extends Seeder
{
    public function run(): void
    {
        $discounts = [
            1 => [ // Viettel
                10000 => 1.8,
                20000 => 1.8,
                50000 => 1.8,
                100000 => 1.8,
                200000 => 1.8,
                500000 => 1.8,
            ],
            2 => [ // Vinaphone
                10000 => 4,
                20000 => 4,
                50000 => 4,
                100000 => 4,
                200000 => 4,
                500000 => 4,
            ],
            3 => [ // Vietnamobile
                10000 => 4.2,
                20000 => 4.2,
                50000 => 4.2,
                100000 => 4.2,
                200000 => 4.2,
                500000 => 4.2,
            ],
            4 => [ // Mobifone
                10000 => 3,
                20000 => 3,
                50000 => 3,
                100000 => 3,
                200000 => 3,
                500000 => 3,
            ],
            5 => [ // Zing
                10000 => 3.1,
                20000 => 3.1,
                50000 => 3.1,
                100000 => 3.1,
                200000 => 3.1,
                500000 => 3.1,
                1000000 => 3.1,
            ],
            6 => [ // Garena
                100000 => 6,
                200000 => 13,
                500000 => 15,
                1000000 => 15,
            ],
            7 => [ // Appota
                50000 => 3,
                100000 => 3,
                200000 => 3,
                500000 => 5.1,
                1000000 => 5.1,
                2000000 => 5.1,
                3000000 => 5.1,
                5000000 => 5.1,
            ],
            8 => [ // Carot
                100000 => 8,
                200000 => 10,
                500000 => 10,
            ],
            9 => [ // Funcard
                10000 => 4.3,
                20000 => 4.3,
                50000 => 4.3,
                100000 => 4.3,
                200000 => 4.3,
                500000 => 4.3,
                1000000 => 4.3,
            ],
            10 => [ // Scoin
                10000 => 4.5,
                20000 => 4.5,
                50000 => 4.5,
                100000 => 4.5,
                200000 => 4.5,
                500000 => 4.5,
                1000000 => 4.5,
            ],
            11 => [ // Vcoin
                10000 => 4.7,
                20000 => 4.7,
                50000 => 4.7,
                100000 => 4.7,
                200000 => 4.7,
                500000 => 4.7,
                1000000 => 4.7,
            ],
        ];

        foreach ($discounts as $nhacungcap_id => $menhgia_chietkhau) {
            foreach ($menhgia_chietkhau as $menh_gia => $chiet_khau) {
                DB::table('mathecao_danhsach')->insert([
                    'nhacungcap_id' => $nhacungcap_id,
                    'menh_gia' => $menh_gia,
                    'chiet_khau' => $chiet_khau,
                    'ngay_tao' => now(),
                    'ngay_cap_nhat' => now(),
                    'trang_thai' => 'hoat_dong',
                ]);
            }
        }
    }
}
