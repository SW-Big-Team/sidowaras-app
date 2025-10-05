<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kandungan_obat', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->json('nama_kandungan');
            $table->string('dosis_kandungan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kandungan_obat');
    }
};