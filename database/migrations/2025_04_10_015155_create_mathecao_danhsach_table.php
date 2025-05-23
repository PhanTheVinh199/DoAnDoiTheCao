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
        Schema::create('mathecao_danhsach', function (Blueprint $table) {
            $table->id('id_mathecao');
            $table->foreignId('nhacungcap_id')->constrained('mathecao_nhacungcap', 'id_nhacungcap');
            $table->integer('menh_gia');
            $table->decimal('chiet_khau', 5, 2)->default(0);
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->nullable();
            $table->enum('trang_thai',  ['hoat_dong', 'an'])->default('hoat_dong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mathecao_danhsach');
    }
};
