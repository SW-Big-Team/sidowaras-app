<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('transaksi_id')->constrained('transaksi');
            $table->foreignId('batch_id')->constrained('stok_batch');
            $table->integer('jumlah');
            $table->decimal('harga_saat_transaksi', 15, 2);
            $table->decimal('sub_total', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};