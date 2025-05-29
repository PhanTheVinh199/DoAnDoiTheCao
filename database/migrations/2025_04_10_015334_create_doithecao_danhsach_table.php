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
        Schema::create('doithecao_danhsach', function (Blueprint $table) {
            $table->id('id_doithecao');
            $table->foreignId('nhacungcap_id')->constrained('doithecao_nhacungcap', 'id_nhacungcap');
            $table->integer('menh_gia');
            $table->decimal('chiet_khau', 5, 2)->default(0);
            $table->boolean('trang_thai')->default(true);
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doithecao_danhsach');
    }
};

