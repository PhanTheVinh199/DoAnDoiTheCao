<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NganHangSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = 1; // ID của admin
        $banks = [];

        $tenNganHang = ['Vietcombank', 'Techcombank', 'ACB', 'BIDV', 'VPBank'];

        for ($i = 1; $i <= 50; $i++) {
            $banks[] = [
                'thanhvien_id' => $adminId,
                'ten_ngan_hang' => $tenNganHang[array_rand($tenNganHang)],
                'chu_tai_khoan' => 'Công Ty TNHH ABC',
                'so_tai_khoan' => '0123456789' . $i,
                'trang_thai' => 'hoat_dong',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('nganhang')->insert($banks);
    }
}