<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPaygateCodeToLichsuNapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lichsu_nap', function (Blueprint $table) {
            // Kiểm tra xem cột 'paygate_code' đã tồn tại chưa
            if (!in_array('paygate_code', DB::getSchemaBuilder()->getColumnListing('lichsu_nap'))) {
                // Thêm cột paygate_code vào bảng lichsu_nap
                $table->unsignedBigInteger('paygate_code')->nullable();  // Cột paygate_code
            }

            // Kiểm tra xem cột 'transfer_note' đã tồn tại chưa
            if (!in_array('transfer_note', DB::getSchemaBuilder()->getColumnListing('lichsu_nap'))) {
                // Thêm cột transfer_note vào bảng lichsu_nap
                $table->string('transfer_note')->nullable();
            }

            // Tạo khóa ngoại cho cột paygate_code liên kết với id_danhsach trong bảng nganhang
            $table->foreign('paygate_code')->references('id_danhsach')->on('nganhang')
                  ->onDelete('set null'); // Khi ngân hàng bị xóa, cột paygate_code sẽ được set null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lichsu_nap', function (Blueprint $table) {
            // Xóa khóa ngoại và cột paygate_code khi rollback migration
            $table->dropForeign(['paygate_code']);
            $table->dropColumn('paygate_code');
            $table->dropColumn('transfer_note');
        });
    }
}
