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
        $kategoris = [
            'Obat Keras',
            'Obat Bebas',
            'Obat Bebas Terbatas',
            'Herbal',
            'Alat Kesehatan',
        ];

        foreach ($kategoris as $nama) {
            KategoriObat::firstOrCreate(
                ['nama_kategori' => $nama],
                ['uuid' => Str::uuid()]
            );
        }
    }
}
