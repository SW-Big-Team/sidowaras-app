<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stok_batch', function (Blueprint $table) {
            // Hapus foreign key lama (jika ada)
            $table->dropForeign(['pembelian_id']);
            
            // Ubah kolom menjadi char(36)
            $table->char('pembelian_id', 36)->nullable()->change();
            
            // Tambahkan foreign key ke pembelian.uuid
            $table->foreign('pembelian_id')
                  ->references('uuid')
                  ->on('pembelian')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('stok_batch', function (Blueprint $table) {
            $table->dropForeign(['pembelian_id']);
            // Kembalikan ke foreignId (BIGINT)
            $table->foreignId('pembelian_id')->nullable()->constrained('pembelian')->nullOnDelete();
        });
    }
};