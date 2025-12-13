<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->json('kandungan_id')->nullable();
            $table->string('kode_obat', 50)->unique()->nullable();
            $table->string('nama_obat');
            $table->text('deskripsi')->nullable();
            $table->foreignId('kategori_id')->constrained('kategori_obat');
            $table->foreignId('satuan_obat_id')->constrained('satuan_obat');
            $table->integer('stok_minimum')->default(10);
            $table->boolean('is_racikan')->default(false);
            $table->string('lokasi_rak', 50)->nullable();
            $table->string('barcode', 100)->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};