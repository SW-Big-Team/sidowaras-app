<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('nama_role', 'Admin')->first();

        if ($adminRole) {
            User::firstOrCreate([
                'uuid' => Str::uuid(),
                'role_id' => $adminRole->id,
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'), 
                'is_active' => true,
            ]);
        }
    }
}

