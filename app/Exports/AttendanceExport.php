<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return \App\Models\Attendance::select('employee_id', 'state', 'timestamp', 'machine_sn')->limit(10)->get();
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'State',
            'Timestamp',
            'Machine SN',
        ];
    }
}
