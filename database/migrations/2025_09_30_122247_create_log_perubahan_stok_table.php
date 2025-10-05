<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_perubahan_stok', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('batch_id')->constrained('stok_batch');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_perubahan_stok');
    }
};