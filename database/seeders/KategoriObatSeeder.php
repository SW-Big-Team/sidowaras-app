<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriObat;
use Illuminate\Support\Str;

class KategoriObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriObat::create(['uuid' => Str::uuid(), 'nama_kategori' => 'Obat Keras']);
        KategoriObat::create(['uuid' => Str::uuid(), 'nama_kategori' => 'Obat Bebas']);
        KategoriObat::create(['uuid' => Str::uuid(), 'nama_kategori' => 'Obat Bebas Terbatas']);
        KategoriObat::create(['uuid' => Str::uuid(), 'nama_kategori' => 'Herbal']);
        KategoriObat::create(['uuid' => Str::uuid(), 'nama_kategori' => 'Alat Kesehatan']);
    }
}
