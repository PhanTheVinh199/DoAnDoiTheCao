<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
{
    Schema::table('doithecao_danhsach', function (Blueprint $table) {
        // Kiểm tra bảng có cột created_at không
        if (!Schema::hasColumn('doithecao_danhsach', 'created_at')) {
            $table->timestamp('created_at')->nullable();
        }

        // Tương tự cho updated_at
        if (!Schema::hasColumn('doithecao_danhsach', 'updated_at')) {
            $table->timestamp('updated_at')->nullable();
        }
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doithecao_danhsach', function (Blueprint $table) {
            //
        });
    }
};
