<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoithecaoDanhsachSeeder extends Seeder
{
    public function run(): void
    {
        $nhacungcapIds = DB::table('doithecao_nhacungcap')->pluck('id_nhacungcap');

        if ($nhacungcapIds->isEmpty()) {
            $this->command->error('❌ Bảng doithecao_nhacungcap chưa có dữ liệu. Hãy seed trước.');
            return;
        }

        foreach ($nhacungcapIds as $nccId) {
            DB::table('doithecao_danhsach')->insert([
                [
                    'nhacungcap_id' => $nccId,
                    'menh_gia' => 10000,
                    'chiet_khau' => 3.00,
                    'trang_thai' => true,
                ],
                [
                    'nhacungcap_id' => $nccId,
                    'menh_gia' => 50000,
                    'chiet_khau' => 4.50,
                    'trang_thai' => true,
                ],
                [
                    'nhacungcap_id' => $nccId,
                    'menh_gia' => 100000,
                    'chiet_khau' => 5.00,
                    'trang_thai' => true,
                ]
            ]);
        }
    }
}
