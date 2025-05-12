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
        Schema::create('nap_tiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thanhvien_id')->constrained('thanhviens')->onDelete('cascade'); // Liên kết với bảng thanhviens
            $table->decimal('so_tien_nap', 10, 2); // Số tiền nạp
            $table->string('noi_dung'); // Nội dung giao dịch
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'huy'])->default('cho_duyet'); // Trạng thái giao dịch
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nap_tiens');
    }
};