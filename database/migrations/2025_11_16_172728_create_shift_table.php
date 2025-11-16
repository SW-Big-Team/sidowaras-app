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
        Schema::create('shift', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name');
            $table->enum('shift_day_of_week', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
            $table->time('shift_start');
            $table->time('shift_end');
            $table->boolean('shift_status')->default(true);
            $table->json('user_list')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift');
    }
};