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
        Schema::create('lichsu_nap', function (Blueprint $table) {
            $table->id('id_lichsunap');
            $table->string('ma_don', 50)->unique();
            $table->foreignId('thanhvien_id')->constrained('thanhvien', 'id_thanhvien');
            $table->integer('so_tien_nap');
            $table->text('noi_dung')->nullable();
            $table->timestamp('ngay_tao')->useCurrent();
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'huy'])->default('cho_duyet');

            // Các cột mới thêm vào để lưu thông tin ngân hàng
            $table->string('bank_name')->nullable();  // Tên ngân hàng
            $table->string('bank_account')->nullable();  // Số tài khoản ngân hàng
            $table->string('bank_account_name')->nullable();  // Tên chủ tài khoản ngân hàng
            $table->string('transfer_note')->nullable();  // Nội dung chuyển khoản
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lichsu_nap', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account', 'bank_account_name', 'transfer_note']);
        });
    }
};
