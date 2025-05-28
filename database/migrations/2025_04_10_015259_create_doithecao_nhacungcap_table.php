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
        Schema::create('doithecao_nhacungcap', function (Blueprint $table) {
            $table->id('id_nhacungcap');
            $table->string('ten', 100);
            $table->string('hinh_anh', 255)->nullable();
            $table->timestamp('ngay_tao')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->enum('trang_thai', ['hoat_dong', 'an'])->default('hoat_dong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doithecao_nhacungcap');
    }
};
