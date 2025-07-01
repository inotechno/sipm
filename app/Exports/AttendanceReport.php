<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceReport implements FromCollection,WithHeadings,WithMapping
{
    protected $employees;
    protected $dateArray;

    public function __construct($employees, $dateArray)
    {
        $this->employees = $employees;
        $this->dateArray = $dateArray;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ubah employees menjadi collection jika diperlukan
        return collect($this->employees);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Membuat heading untuk kolom, termasuk kolom tanggal
        $headings = ['Employee ID', 'Name', 'Supervisor Name', 'Position Name', 'Phone', 'Shift'];

        foreach ($this->dateArray as $date) {
            $headings[] = \Carbon\Carbon::parse($date)->format('d/m'); // Format 'd/m'
        }

        return $headings;
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($employee): array
    {
        // Ambil data karyawan dan semua absensinya
        $data = [
            $employee['employee_id'],
            $employee['name'],
            $employee['supervisor_name'],
            $employee['position_name'],
            $employee['phone'],
            $employee['shift'],
        ];

        foreach ($this->dateArray as $date) {
            // Cek jika ada absensi untuk tanggal ini
            $attendanceOnDate = $employee['attendance'][$date] ?? '-'; // Jika tidak ada absensi, tampilkan '-'
            $data[] = $attendanceOnDate;
        }

        return $data;
    }
}
