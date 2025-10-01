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
        Schema::table('users', function (Blueprint $table) {
            
            $table->renameColumn('name', 'nama_lengkap');
            $table->renameColumn('password', 'password_hash');
            $table->uuid()->unique()->after('id');
            $table->foreignId('role_id')->after('uuid')->constrained('roles');
            $table->boolean('is_active')->default(true)->after('password_hash');
            $table->dropColumn(['email', 'email_verified_at', 'remember_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('email')->unique()->after('nama_lengkap');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->rememberToken()->after('password_hash');
            $table->dropForeign(['role_id']);
            $table->dropColumn(['uuid', 'role_id', 'username', 'is_active']);
            $table->renameColumn('nama_lengkap', 'name');
            $table->renameColumn('password_hash', 'password');
        });
    }
};