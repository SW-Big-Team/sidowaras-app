<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_stock_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_opname_id')->constrained('stock_opname')->cascadeOnDelete();
            $table->foreignId('obat_id')->constrained('obat');
            $table->integer('system_qty'); // Stok sistem saat opname
            $table->integer('physical_qty'); // Stok fisik hasil hitung
            $table->text('notes')->nullable(); // Catatan karyawan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_stock_opname');
    }
};