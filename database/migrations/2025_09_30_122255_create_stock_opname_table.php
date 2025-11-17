<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('stock_opname', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal'); // Tanggal opname
        $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
        $table->foreignId('created_by')->constrained('users'); // Karyawan yang input
        $table->foreignId('approved_by')->nullable()->constrained('users'); // Admin yang approve
        $table->timestamp('approved_at')->nullable(); // Waktu approval/rejection
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('stock_opname');
    }
};