<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('doithecao_nhacungcap', function (Blueprint $table) {
        if (!Schema::hasColumn('doithecao_nhacungcap', 'updated_at')) {
            $table->timestamp('updated_at')->nullable();
        }
    });
}


    public function down(): void
    {
        Schema::table('doithecao_nhacungcap', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
    }
};
