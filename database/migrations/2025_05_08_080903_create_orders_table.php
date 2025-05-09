<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // Mã đơn hàng
            $table->foreignId('user_id')->constrained('thanhviens'); // Liên kết với bảng người dùng
            $table->decimal('total_amount', 15, 2); // Tổng số tiền
            $table->string('status')->default('pending'); // Trạng thái đơn hàng
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
