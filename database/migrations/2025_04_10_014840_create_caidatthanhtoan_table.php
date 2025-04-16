<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caidatthanhtoan', function (Blueprint $table) {
            $table->id('id_thanhtoan');
            $table->foreignId('thanhvien_id')->constrained('thanhvien', 'id_thanhvien');
            $table->string('ngan_hang', 100)->nullable();
            $table->string('so_tai_khoan', 50)->nullable();
            $table->string('chu_tai_khoan', 100)->nullable();
            $table->text('noi_dung_nap')->nullable();
            $table->boolean('trang_thai')->default(true);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caidatthanhtoan');
    }
};
