<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('user_id')->nullable(); // null = untuk semua user dengan role tertentu
            $table->string('role')->nullable(); // Admin, Karyawan, Kasir, atau null untuk user spesifik
            $table->string('type'); // stok_menipis, kadaluarsa, pembelian_baru, stock_opname_pending, dll
            $table->boolean('is_warning')->default(false); // true = persistent warning, false = event notification
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable();
            $table->string('icon_color')->default('primary');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_read', 'is_warning']);
            $table->index(['role', 'is_read', 'is_warning']);
            $table->index(['type', 'is_warning']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
