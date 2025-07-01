<?php

namespace App\Livewire\ReportAttendance;

use App\Exports\AttendanceReport;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DatePeriod;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ReportAttendancePreview extends Component
{
    use LivewireAlert;
    public $employees;
    public $dateArray;
    public $countDays = 0;
    public $sortByAttendance = 'asc';

    #[On('refreshAttendances')]
    public function preview($employees, $dateArray)
    {
        $this->reset('employees');

        // dd($employees);
        $this->employees = collect($employees);
        $this->dateArray = $dateArray;
        $this->countDays = count($dateArray);

        $this->sortEmployees();
    }

    public function sortEmployees()
    {
        if ($this->sortByAttendance === 'asc') {
            $this->employees = $this->employees->sortBy('attendance_count')->values();
        } else {
            $this->employees = $this->employees->sortByDesc('attendance_count')->values();
        }
    }

    public function toggleSort()
    {
        if($this->employees == null) return;

        $this->sortByAttendance = $this->sortByAttendance === 'asc' ? 'desc' : 'asc';
        $this->sortEmployees();
    }

    public function exportExcel()
    {
        if($this->employees == null) return;

        $employees = $this->employees;
        $dateArray = $this->dateArray;
        return Excel::download(new AttendanceReport($this->employees, $this->dateArray), 'Report Attendances.xlsx');
    }

    public function render()
    {
        return view('livewire.report-attendance.report-attendance-preview');
    }
}
