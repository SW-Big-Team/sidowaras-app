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
        $roles = ['Admin', 'Karyawan', 'Kasir'];

        foreach ($roles as $nama) {
            Role::firstOrCreate(
                ['nama_role' => $nama],
                ['uuid' => Str::uuid()]
            );
        }
    }
}
