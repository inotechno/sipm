<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\ShiftSchedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        $shifts = Shift::all();

        $month = now()->format('Y-m');
        $daysInMonth = Carbon::parse("{$month}-01")->daysInMonth; // Jumlah hari dalam bulan ini

        foreach ($employees as $employee) {
            $shiftIndex = 0;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::parse("{$month}-{$day}");

                // Tentukan shift berdasarkan rotasi
                $shift = $shifts[$shiftIndex % $shifts->count()];

                // Buat jadwal shift
                ShiftSchedule::create([
                    'employee_id' => $employee->id,
                    'shift_id' => $shift->id,
                    'date' => $currentDate->toDateString(),
                ]);

                // Ganti rotasi shift setiap minggu
                if ($currentDate->dayOfWeek === Carbon::SUNDAY) {
                    $shiftIndex++;
                }
            }
        }
    }
}
