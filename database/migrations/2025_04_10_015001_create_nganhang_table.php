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
            $table->unsignedBigInteger('thanhvien_id');
            $table->foreign('thanhvien_id')->references('id_thanhvien')->on('thanhvien')->onDelete('cascade');
            $table->string('ten_ngan_hang', 100)->nullable();
            $table->string('chu_tai_khoan', 100)->nullable();
            $table->string('so_tai_khoan', 100)->nullable();
            $table->enum('trang_thai', ['hoat_dong', 'da_huy', 'cho_xu_ly'])->default('cho_xu_ly');
            $table->timestamps();
           
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