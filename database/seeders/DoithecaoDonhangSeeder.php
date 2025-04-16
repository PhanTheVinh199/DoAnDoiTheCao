<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoithecaoDonhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Giả sử bạn đã có các ID hợp lệ trong bảng doithecao_danhsach và thanhvien
        $doithecaoIds = DB::table('doithecao_danhsach')->pluck('id_doithecao');
        $thanhvienIds = DB::table('thanhvien')->pluck('id_thanhvien');


        foreach (range(1, 10) as $index) {
            DB::table('doithecao_donhang')->insert([
                'ma_don' => 'DON' . strtoupper(Str::random(10)),
                'ma_the' => Str::random(16),
                'serial' => Str::random(12),
                'doithecao_id' => $doithecaoIds->random(),
                'so_luong' => rand(1, 5),
                'thanh_tien' => rand(50000, 500000),
                'thanhvien_id' => $thanhvienIds->random(),
                'ngay_tao' => now(),
                'trang_thai' => collect(['hoat_dong', 'da_huy', 'cho_xu_ly'])->random(),
            ]);
        }
    }
}
