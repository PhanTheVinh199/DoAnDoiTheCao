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
            // Tạo khóa chính tự động
            $table->id('id_danhsach');

            // Khóa ngoại đến bảng thanhvien (có thể null nếu không bắt buộc phải có thành viên)
            $table->unsignedBigInteger('thanhvien_id')->nullable();  // Đặt nullable nếu cần
            $table->foreign('thanhvien_id')->references('id_thanhvien')->on('thanhvien')->onDelete('cascade');

            // Các trường thông tin của ngân hàng
            $table->string('ten_ngan_hang', 100)->nullable();
            $table->string('chu_tai_khoan', 100)->nullable();
            $table->string('so_tai_khoan', 100)->nullable();

            // Trạng thái ngân hàng
            $table->enum('trang_thai', ['hoat_dong', 'da_huy', 'cho_xu_ly'])->default('cho_xu_ly');

            // Các trường theo dõi thời gian
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
