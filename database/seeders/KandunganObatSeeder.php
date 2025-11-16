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
        $kandungans = [
            ['nama_kandungan' => ['Paracetamol'], 'dosis_kandungan' => '500mg'],
            ['nama_kandungan' => ['Ibuprofen'], 'dosis_kandungan' => '200mg'],
            ['nama_kandungan' => ['Amoxicillin'], 'dosis_kandungan' => '500mg'],
            ['nama_kandungan' => ['Cetirizine'], 'dosis_kandungan' => '10mg'],
            ['nama_kandungan' => ['Loratadine'], 'dosis_kandungan' => '10mg'],
            ['nama_kandungan' => ['Omeprazole'], 'dosis_kandungan' => '20mg'],
            ['nama_kandungan' => ['Metformin'], 'dosis_kandungan' => '500mg'],
            ['nama_kandungan' => ['Amlodipine'], 'dosis_kandungan' => '5mg'],
        ];

        foreach ($kandungans as $data) {
            KandunganObat::firstOrCreate(
                [
                    'nama_kandungan' => $data['nama_kandungan'], // Langsung array, tidak perlu json_encode
                    'dosis_kandungan' => $data['dosis_kandungan'],
                ],
                [
                    'uuid' => Str::uuid(),
                ]
            );
        }
    }
}