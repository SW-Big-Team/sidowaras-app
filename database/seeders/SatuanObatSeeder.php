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
        $satuans = [
            'Tablet',
            'Kapsul',
            'Strip',
            'Botol',
            'Box',
            'Tube',
            'Pcs',
        ];

        foreach ($satuans as $nama) {
            SatuanObat::firstOrCreate(
                ['nama_satuan' => $nama],
                ['uuid' => Str::uuid()]
            );
        }
    }
}
