<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_stock_opname', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('opname_id')->constrained('stock_opname');
            $table->foreignId('batch_id')->constrained('stok_batch');
            $table->integer('stok_tercatat');
            $table->integer('stok_fisik');
            $table->integer('selisih');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_stock_opname');
    }
};