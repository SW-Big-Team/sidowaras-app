<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SatuanObat;
use Illuminate\Support\Str;

class SatuanObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Tablet']);
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Kapsul']);
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Strip']);
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Botol']);
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Box']);
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Tube']);
        SatuanObat::create(['uuid' => Str::uuid(), 'nama_satuan' => 'Pcs']);
    }
}
