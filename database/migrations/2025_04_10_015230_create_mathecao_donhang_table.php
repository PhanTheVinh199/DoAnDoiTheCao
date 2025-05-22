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
        Schema::create('mathecao_donhang', function (Blueprint $table) {
            $table->id('id_donbanthe');
            $table->string('ma_don', 50)->unique();
            $table->foreignId('mathecao_id')->constrained('mathecao_danhsach', 'id_mathecao');
            $table->integer('so_luong');
            $table->integer('thanh_tien');
            $table->foreignId('thanhvien_id')->constrained('thanhvien', 'id_thanhvien');
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->nullable();
            $table->enum('trang_thai', ['hoat_dong', 'da_huy', 'cho_xu_ly'])->default('cho_xu_ly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mathecao_donhang');
    }
};
