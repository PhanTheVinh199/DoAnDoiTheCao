<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('thanhvien', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('tai_khoan');
        });
    }

    public function down()
    {
        Schema::table('thanhvien', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};