<?php

namespace Database\Seeders;
use App\Models\NganHang;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NganHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NganHang::factory()->count(10)->create();

    }
}
