<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shift;
class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shift::create([
            'shift_name' => 'Senin Pagi',
            'shift_day_of_week' => 'senin',
            'shift_start' => '09:00:00',
            'shift_end' => '15:00:00',
            'shift_status' => true,
            'user_list' => null,
        ]);
        Shift::create([
            'shift_name' => 'Senin Sore',
            'shift_day_of_week' => 'senin',
            'shift_start' => '15:00:00',
            'shift_end' => '21:00:00',
            'shift_status' => true,
            'user_list' => null,
        ]);
        Shift::create([
            'shift_name' => 'Selasa Pagi',
            'shift_day_of_week' => 'selasa',
            'shift_start' => '09:00:00',
            'shift_end' => '15:00:00',
            'shift_status' => true,
            'user_list' => null,
        ]);
    }
}
