<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Admin']);
        Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Karyawan']);
        Role::create(['uuid' => Str::uuid(), 'nama_role' => 'Kasir']);
    }
}
