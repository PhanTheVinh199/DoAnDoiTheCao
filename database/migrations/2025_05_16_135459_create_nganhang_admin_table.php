<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNganhangAdminTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nganhang_admin', function (Blueprint $table) {
            $table->id('id_danhsach');  // Khóa chính
            $table->unsignedBigInteger('thanhvien_id')->nullable(); // Khóa ngoại tới bảng thanhvien
            $table->string('ten_ngan_hang', 100);
            $table->string('so_tai_khoan', 50)->unique();
            $table->string('chu_tai_khoan', 100);
            $table->enum('trang_thai', ['hoat_dong', 'khong_hoat_dong'])->default('hoat_dong');
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('thanhvien_id')->references('id_thanhvien')->on('thanhvien')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nganhang_admin');
    }
}
