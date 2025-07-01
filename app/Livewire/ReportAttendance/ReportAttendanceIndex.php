<?php

namespace App\Livewire\ReportAttendance;

use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;
use Livewire\Attributes\On;

class ReportAttendanceIndex extends Component
{
    public $filterGroup = [];
    public $filterPosition = [];
    public $filterStartDate = '';
    public $filterEndDate = '';
    public $filterEmployee = [];
    public $filterShift = '';

    public $groups = [];
    public $positions = [];
    public $employees = [];

    public $dateArray = [];

    public $attendances;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
        'refreshList' => 'handleRefresh',
    ];

    protected $queryString = [
        'perPage' => ['except' => 30],
        'filterGroup' => ['except' => []],
        'filterPosition' => ['except' => []],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
        'filterEmployee' => ['except' => []],
        'filterShift' => ['except' => ''],
    ];

    public function resetFilter()
    {
        $this->filterGroup = [];
        $this->filterPosition = [];
        $this->filterStartDate = '';
        $this->filterEndDate = '';
        $this->filterEmployee = [];
        $this->filterShift = '';

        $this->dispatch('reset-select2');
    }

    #[On('filterEmployeeSelected')]
    public function filterEmployeeSelected($value)
    {
        $this->filterEmployee = $value;
    }

    #[On('filterGroupSelected')]
    public function filterGroupSelected($value)
    {
        $this->filterGroup = $value;
    }

    #[On('filterPositionSelected')]
    public function filterPositionSelected($value)
    {
        $this->filterPosition = $value;
    }

    public function handleRefresh()
    {
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        $this->groups = \App\Models\Group::all();
        $this->positions = \App\Models\Position::all();
        $this->employees = \App\Models\Employee::all();
    }

    public function preview()
    {
        $this->validate([
            'filterStartDate' => 'required',
            'filterEndDate' => 'required',
        ]);

        // Pastikan rentang tanggal tersedia
        $startDate = Carbon::parse($this->filterStartDate);
        $endDate = Carbon::parse($this->filterEndDate)->endOfDay();

        // Ambil semua data attendance sesuai filter
        $attendances = Attendance::with('employee.group.supervisor', 'employee.position')
            ->when($this->filterGroup, function ($query) {
                $query->whereHas('employee.group', function ($query) {
                    $query->whereIn('id', $this->filterGroup);
                });
            })
            ->when($this->filterShift !== '', function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('shift', $this->filterShift);
                });
            })
            ->when($this->filterPosition, function ($query) {
                $query->whereHas('employee.position', function ($query) {
                    $query->whereIn('id', $this->filterPosition);
                });
            })
            ->when($this->filterEmployee, function ($query) {
                $query->whereIn('employee_id', $this->filterEmployee);
            })
            ->whereBetween('timestamp', [$startDate, $endDate]) // Filter rentang tanggal
            ->onlyActiveEmployees()
            ->get();

        // Menghasilkan rentang tanggal
        $rangeDates = CarbonPeriod::create($startDate, $endDate);

        // Convert hasil ke array jika diperlukan
        $dateArray = [];
        foreach ($rangeDates as $date) {
            $dateArray[] = $date->toDateString(); // Format menjadi 'YYYY-MM-DD'
        }

        $this->dateArray = $dateArray;

        // Proses data menjadi format yang diinginkan
        $employees = $attendances->groupBy('employee_id')->map(function ($employeeAttendances) use ($startDate, $endDate) {
            $employee = $employeeAttendances->first()->employee; // Ambil data karyawan
            $dates = [];

            $attendanceCount = 0;
            // Loop rentang tanggal
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $formattedDate = $date->format('Y-m-d'); // Format tanggal 'YYYY-MM-DD'

                // Cari attendance pada tanggal ini
                $attendanceOnDate = $employeeAttendances->filter(function ($attendance) use ($formattedDate) {
                    // Cek apakah attendance berada dalam rentang tanggal yang sesuai
                    $attendanceDate = Carbon::parse($attendance->timestamp)->toDateString();
                    return $attendanceDate == $formattedDate;
                });

                if ($attendanceOnDate->isNotEmpty()) {
                    // Ambil semua waktu absensi pada hari tersebut
                    $times = $attendanceOnDate->map(function ($attendance) {
                        return Carbon::parse($attendance->timestamp)->format('H:i'); // Format waktu 'H:i'
                    });

                    // Gabungkan semua waktu dalam satu string, dipisahkan oleh koma
                    $dates[$formattedDate] = $times->implode(', ');
                    $attendanceCount += $attendanceOnDate->count(); // Tambahkan jumlah absensi
                } else {
                    $dates[$formattedDate] = '-'; // Jika tidak ada absensi, tampilkan '-'
                }
            }

            return [
                'employee_id' => $employee->id,
                'supervisor_name' => $employee->group?->supervisor?->name,
                'position_name' => $employee->position?->name,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'shift' => $employee->shift,
                'attendance' => $dates, // Tanggal dengan jam absensi
                'attendance_count' => $attendanceCount, // Tambahkan jumlah absensi
            ];
        });

        // dd($employees);
        // Kirim data ke frontend
        $this->dispatch('refreshAttendances', employees: $employees, dateArray: $this->dateArray);
    }

    public function render()
    {
        return view('livewire.report-attendance.report-attendance-index')->layout('layouts.app', ['title' => 'Report Attendance']);
    }
}
