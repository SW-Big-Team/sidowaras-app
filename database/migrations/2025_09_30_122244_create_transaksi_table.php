<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('no_transaksi', 50)->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('total_bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->dateTime('tgl_transaksi')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};