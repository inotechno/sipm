<?php

namespace Database\Seeders;

use App\Models\AttendanceConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendanceConfig::create([
            'name' => 'Check In',
            'start_time' => '07:00:00',
            'end_time' => '10:00:00',
            'sequence' => 1,
            'bgColor' => 'primary',
            'textColor' => 'text-white',
        ]);

        AttendanceConfig::create([
            'name' => 'Break Out',
            'start_time' => '12:00:00',
            'end_time' => '12:59:00',
            'sequence' => 2,
            'bgColor' => 'info',
            'textColor' => 'text-white',
        ]);

        AttendanceConfig::create([
            'name' => 'Break In',
            'start_time' => '13:00:00',
            'end_time' => '15:00:00',
            'sequence' => 3,
            'bgColor' => 'info',
            'textColor' => 'text-white',
        ]);

        AttendanceConfig::create([
            'name' => 'Check Out',
            'start_time' => '17:00:00',
            'end_time' => '19:00:00',
            'sequence' => 4,
            'bgColor' => 'primary',
            'textColor' => 'text-white',
        ]);

        AttendanceConfig::create([
            'name' => 'Night Shift',
            'start_time' => '19:00:00',
            'end_time' => '06:59:00',
            'sequence' => 5,
            'bgColor' => 'secondary',
            'textColor' => 'text-white',
        ]);
    }
}
