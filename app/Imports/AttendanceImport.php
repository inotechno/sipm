<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {

            $employee = $this->getEmployee($row['employee_id']);

            $name = '';
            $phone = '';
            $shift = null;
            $shiftDate = null;
            $is_active = false;

            if ($employee != null) {
                $name = $employee->name;
                $phone = $employee->phone;
                $is_active = true;
            } else {
                $employee = Employee::updateOrCreate([
                    'id' => $row['employee_id']
                ], [
                    'name' => $row['employee_id'],
                ]);

                $name = $employee->name;
                $is_active = false;
            }

            $shift_employee = $employee->shift;
            // $machine = Machine::where('serial_number', $request->input('SN'))->first();
            // $shift_employee = $machine->shift;

            $dayOfWeek = Carbon::parse($row['timestamp'])->format('l'); // Mendapatkan nama hari

            if ($shift_employee == 1) {
                $dayOfWeek = Carbon::parse($row['timestamp'])->format('l'); // Mendapatkan nama hari
                $shiftDate = Carbon::parse($row['timestamp'])->toDateString();
            } else if ($shift_employee == 2) {
                if (Carbon::parse($row['timestamp'])->hour >= 0 && Carbon::parse($row['timestamp'])->hour <= 11) {
                    $dayOfWeek = Carbon::parse($row['timestamp'])->subDay()->format('l');
                    $shiftDate = Carbon::parse($row['timestamp'])->subDay()->toDateString();
                } else {
                    $dayOfWeek = Carbon::parse($row['timestamp'])->format('l'); // Mendapatkan nama hari
                    $shiftDate = Carbon::parse($row['timestamp'])->toDateString();
                }
            }

            // Ambil semua shift yang berlaku untuk hari tersebut
            $shift = Shift::where('day_of_week', strtolower($dayOfWeek))->where('shift', $shift_employee)->first();

            if (!isset($shift)) {
                \Log::info('Shift Not Found', $row);
            }

            if (isset($shift)) {

                $attendance = Attendance::updateOrCreate([
                    'employee_id' => $row['employee_id'],
                    'timestamp' => $row['timestamp'],
                    'machine_sn' => $row['machine_sn'],
                    'shift_id' => $shift->id,
                    'state' => $row['state'],
                    'shift_date' => $shiftDate,
                    'uid' => $row['employee_id'] . date('dHi'),
                ], [
                    'employee_id' => $row['employee_id'],
                    'timestamp' => $row['timestamp'],
                    'machine_sn' => $row['machine_sn'],
                    'shift_id' => $shift->id,
                    'state' => $row['state'],
                    'shift_date' => $shiftDate,
                    'uid' => $row['employee_id'] . date('dHi'),
                ]);

                return $attendance;
            } else {
                return null;
            }

        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return null;
        }
    }

    protected function getEmployee($id)
    {
        return Employee::withTrashed()->find($id) ?? null;
    }

}
