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
        Schema::create('pembayaran_termin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')
                  ->constrained('pembelian')
                  ->onDelete('cascade');
            $table->tinyInteger('termin_ke'); 
            $table->decimal('jumlah_bayar', 15, 2);
            $table->date('tgl_jatuh_tempo');
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->date('tgl_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['pembelian_id', 'termin_ke']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_termin');
    }
};