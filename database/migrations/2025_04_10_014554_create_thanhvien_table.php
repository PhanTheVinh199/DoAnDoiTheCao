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
        Schema::create('thanhvien', function (Blueprint $table) {
            $table->id('id_thanhvien');
            $table->string('tai_khoan', 50)->unique();
            $table->string('ho_ten', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('mat_khau',255);
            $table->integer('so_du')->default(0);
            $table->enum('quyen', ['admin', 'user'])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanhvien');
    }
};
