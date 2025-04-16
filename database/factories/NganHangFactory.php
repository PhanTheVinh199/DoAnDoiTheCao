<?php

namespace Database\Factories;

use App\Models\ThanhVien; // nếu có model thanhvien
use Illuminate\Database\Eloquent\Factories\Factory;

class NganHangFactory extends Factory
{
    public function definition()
    {
        return [
            'thanhvien_id' => $this->faker->randomNumber(),
            'ten_ngan_hang' => $this->faker->company,
            'chu_tai_khoan' => $this->faker->name,
            'so_tai_khoan' => $this->faker->bankAccountNumber,
            'trang_thai' => 'hoat_dong',
        ];
    }
    
}