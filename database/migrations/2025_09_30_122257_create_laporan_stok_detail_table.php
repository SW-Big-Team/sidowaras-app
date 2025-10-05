<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_stok_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('laporan_id')->constrained('laporan_stok');
            $table->uuid('batch_uuid');
            $table->string('obat_kode', 50)->nullable();
            $table->string('obat_nama')->nullable();
            $table->string('no_batch', 100)->nullable();
            $table->decimal('harga_beli', 15, 2)->nullable();
            $table->decimal('harga_jual', 15, 2)->nullable();
            $table->integer('stok_saat_laporan');
            $table->date('tgl_kadaluarsa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_stok_detail');
    }
};