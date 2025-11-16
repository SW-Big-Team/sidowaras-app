<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class, 
            KategoriObatSeeder::class,
            SatuanObatSeeder::class,
            KandunganObatSeeder::class,
            ObatSeeder::class,
        ]);
    }
}

