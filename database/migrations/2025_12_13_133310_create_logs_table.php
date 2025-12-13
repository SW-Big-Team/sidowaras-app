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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action', 50); // create, update, delete, view, login, logout, etc.
            $table->string('model_type')->nullable(); // App\Models\Obat, App\Models\Pembelian, etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the affected model
            $table->text('description')->nullable(); // Human-readable description
            $table->string('ip_address', 45)->nullable(); // IPv6 compatible
            $table->text('user_agent')->nullable(); // Browser/device info
            $table->json('request_data')->nullable(); // Request payload/data
            $table->json('response_data')->nullable(); // Response data
            $table->string('status', 20)->default('success'); // success, error, warning
            $table->text('error_message')->nullable(); // Error details if status is error
            $table->string('route')->nullable(); // Route name or path
            $table->string('method', 10)->nullable(); // GET, POST, PUT, DELETE, etc.
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('user_id');
            $table->index('action');
            $table->index(['model_type', 'model_id']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
