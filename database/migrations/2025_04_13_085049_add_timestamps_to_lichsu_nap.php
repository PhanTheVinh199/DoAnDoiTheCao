<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToLichsuNap extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lichsu_nap', function (Blueprint $table) {
            $table->timestamps();  // Thêm cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lichsu_nap', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']); // Xóa các cột khi rollback
        });
    }
}
