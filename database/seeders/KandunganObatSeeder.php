<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KandunganObat;
use Illuminate\Support\Str;

class KandunganObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nama_kandungans = [
            'Paracetamol',
            'Ibuprofen',
            'Amoxicillin',
            'Cetirizine',
            'Loratadine',
            'Omeprazole',
            'Metformin',
            'Amlodipine',
        ];
        $dosis_kandungans = [
            '500mg',
            '200mg',
            '500mg',
            '10mg',
            '10mg',
            '20mg',
            '500mg',
            '5mg',
        ];
        for ($i = 0; $i < count($nama_kandungans); $i++) {
            KandunganObat::firstOrCreate(
                [
                    'nama_kandungan' => [$nama_kandungans[$i]], 
                    'dosis_kandungan' => $dosis_kandungans[$i],
                ],
                [
                    'uuid' => Str::uuid(),
                ]
            );
        }
    }
}