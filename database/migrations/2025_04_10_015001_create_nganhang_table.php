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
        Schema::create('nganhang', function (Blueprint $table) {
            $table->id('id_danhsach');
            $table->foreignId('thanhvien_id')->constrained('thanhvien', 'id_thanhvien');
            $table->string('ten_ngan_hang', 100)->nullable();
            $table->string('chu_tai_khoan', 100)->nullable();
            $table->boolean('trang_thai')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nganhang');
    }
};
