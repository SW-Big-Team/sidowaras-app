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
            $table->uuid('uuid')->unique();
            $table->foreignId('obat_id')->constrained('obat');
            // gunakan foreignId integer mengacu ke pembelian.id
            $table->foreignId('pembelian_id')->nullable()->constrained('pembelian')->nullOnDelete();
            $table->string('no_batch', 100)->nullable();
            $table->string('barcode', 100)->nullable(); // jangan paksa unique bila bisa duplikat
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