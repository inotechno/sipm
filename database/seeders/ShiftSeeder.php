<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'monday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'monday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'tuesday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'tuesday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'wednesday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'wednesday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'thursday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'thursday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '11:30:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'friday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'friday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'saturday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'saturday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 1',
            'start_time' => '07:00:00',
            'break_start_time' => '12:00:00',
            'break_end_time' => '13:00:00',
            'end_time' => '17:00:00',
            'day_of_week' => 'sunday',
            'start_adjustment' => '06:00:00',
            'end_adjustment' => '17:59:59'
        ]);

        Shift::create([
            'name' => 'Shift 2',
            'start_time' => '19:00:00',
            'break_start_time' => '24:00:00',
            'break_end_time' => '01:00:00',
            'end_time' => '05:00:00',
            'day_of_week' => 'sunday',
            'start_adjustment' => '18:00:00',
            'end_adjustment' => '05:59:59'
        ]);
    }
}
