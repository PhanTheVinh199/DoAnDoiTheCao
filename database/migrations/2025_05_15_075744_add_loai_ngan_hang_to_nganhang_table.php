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
        Schema::table('nganhang', function (Blueprint $table) {
            $table->enum('loai_ngan_hang', ['admin', 'user'])->default('user');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nganhang', function (Blueprint $table) {
            $table->dropColumn('loai_ngan_hang');
        });
    }
};
