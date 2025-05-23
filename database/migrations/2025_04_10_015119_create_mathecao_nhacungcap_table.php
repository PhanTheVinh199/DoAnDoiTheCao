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
        Schema::create('mathecao_nhacungcap', function (Blueprint $table) {
            $table->id('id_nhacungcap');
            $table->string('ten', 100);
            $table->string('hinhanh', 255)->nullable();
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
        Schema::dropIfExists('mathecao_nhacungcap');
    }
};
