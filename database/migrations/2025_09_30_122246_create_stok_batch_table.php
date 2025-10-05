<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_batch', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('obat_id')->constrained('obat');
            $table->uuid('pembelian_id')->nullable();
            $table->foreign('pembelian_id')->references('uuid')->on('pembelian')->onDelete('set null');
            $table->string('no_batch', 100)->nullable();
            $table->string('barcode', 100)->unique()->nullable();
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->integer('jumlah_masuk');
            $table->integer('sisa_stok');
            $table->date('tgl_kadaluarsa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_batch');
    }
};