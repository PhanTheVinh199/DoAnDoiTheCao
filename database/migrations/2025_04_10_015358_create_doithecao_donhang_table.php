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
        Schema::create('doithecao_donhang', function (Blueprint $table) {
            $table->id('id_dondoithe');
            $table->string('ma_don', 50)->unique();
            $table->string('ma_the', 100);
            $table->string('serial', 100);
            $table->foreignId('doithecao_id')->constrained('doithecao_danhsach', 'id_doithecao');
            $table->integer('so_luong');
            $table->integer('thanh_tien');
            $table->foreignId('thanhvien_id')->constrained('thanhvien', 'id_thanhvien');
            $table->timestamp('ngay_tao')->useCurrent();
            $table->enum('trang_thai', ['hoat_dong', 'da_huy', 'cho_xu_ly'])->default('cho_xu_ly');
        });
    }
  

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doithecao_donhang');
    }
};
