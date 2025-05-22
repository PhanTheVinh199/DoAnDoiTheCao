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
        Schema::create('lichsu_rut', function (Blueprint $table) {
            $table->id('id_lichsurut');
            $table->string('ma_don', 50)->unique();
            $table->foreignId('thanhvien_id')->constrained('thanhvien', 'id_thanhvien');
            $table->foreignId('danhsach_id')->constrained('nganhang', 'id_danhsach');
            $table->integer('so_tien_rut');
            $table->timestamps();
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'huy'])->default('cho_duyet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lichsu_rut');
    }
};
