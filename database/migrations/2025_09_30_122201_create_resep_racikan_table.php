<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_racikan', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('obat_racikan_id')->constrained('obat');
            $table->foreignId('obat_komponen_id')->constrained('obat');
            $table->decimal('jumlah', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_racikan');
    }
};