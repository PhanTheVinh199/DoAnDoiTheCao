<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMaTheAndSerialInDoiTheCaoDonhang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('doithecao_donhang', function (Blueprint $table) {
        $table->integer('ma_the')->change();
        $table->integer('serial')->change();
    });
}

public function down()
{
    Schema::table('doithecao_donhang', function (Blueprint $table) {
        $table->string('ma_the')->change();
        $table->string('serial')->change();
    });
}

}
