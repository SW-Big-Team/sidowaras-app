<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('no_faktur', 100)->unique()->nullable();
            $table->string('nama_pengirim', 100);
            $table->string('no_telepon_pengirim', 16)->nullable();
            $table->enum('metode_pembayaran', ['tunai', 'non tunai', 'termin'])->default('tunai')->change();
            $table->dateTime('tgl_pembelian')->useCurrent();
            $table->decimal('total_harga', 15, 2);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};