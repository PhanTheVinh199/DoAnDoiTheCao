<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DoithecaoDanhsachSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Mảng chứa các giá trị mệnh giá
        $menh_gia_values = [10000, 20000, 50000, 100000, 200000, 500000, 1000000];

        // Danh sách nhà cung cấp
        $nhacungcap = [
            1 => 'Viettel',
            2 => 'Vinaphone',
            3 => 'Mobifone',
            4 => 'Zing',
            5 => 'Appota',
            6 => 'Garena',
            7 => 'Vietnamobile',
            8 => 'Carot',
            9 => 'Funcard',
            10 => 'Scoin',
            11=> 'Vcoin',
        ];

        // Lặp qua từng nhà cung cấp
        foreach ($nhacungcap as $nhacungcap_id => $nhacungcap_name) {
            // Lặp qua từng mệnh giá và thêm sản phẩm vào bảng
            foreach ($menh_gia_values as $menh_gia) {
                DB::table('doithecao_danhsach')->insert([
                    'nhacungcap_id' => $nhacungcap_id, // ID nhà cung cấp
                    'menh_gia'      => $menh_gia,     // Mệnh giá
                    'chiet_khau'    => rand(5, 20),   // Chiết khấu ngẫu nhiên từ 5% đến 20%
                    'trang_thai'    => '1',    // Trạng thái ngẫu nhiên: 0 (hủy), 1 (hoạt động)
                    'created_at'    => Carbon::now(), // Thời gian tạo
                    'updated_at'    => Carbon::now(), // Thời gian cập nhật
                ]);
            }
        }
    }
}
