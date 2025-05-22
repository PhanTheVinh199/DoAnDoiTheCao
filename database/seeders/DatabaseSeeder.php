<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            ThanhVienSeeder::class,
            NganHangSeeder::class,
            
            RutTienSeeder::class,
            NapTienSeeder::class,
            MTC_NhaCungCap::class,
            MTC_SanPham::class,
            MTC_DonHang::class,
            DoithecaoNhacungcapSeeder::class,
            DoithecaoDanhsachSeeder::class,
            DoithecaoDonhangSeeder::class,
            NganHangAdminSeeder::class
            

        ]);
        
    }
}
