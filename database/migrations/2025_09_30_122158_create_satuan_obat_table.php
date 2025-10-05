<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satuan_obat', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('nama_satuan', 50)->unique();
            $table->integer('faktor_konversi')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satuan_obat');
    }
};