<?php

namespace App\Livewire\Dashboard;

use App\Models\Attendance;
use App\Models\Position;
use App\Models\Shift;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendancePerPosition extends Component
{
    public $date;
    public $dateString;
    public $shift_id;
    public $shift;
    public $attendanceData = [];

    public $showModal = false;
    public $selectedCategory = '';
    public $selectedDivision = '';
    public $selectedType = '';
    public $supervisorData = [];

    public $employeeData = []; // Untuk menyimpan data karyawan yang akan ditampilkan
    public $selectedSupervisor = ''; // Untuk menyimpan supervisor yang dipilih


    public function mount($date)
    {
        $this->date = $date;
        $this->dateString = Carbon::parse($date)->format('d F Y');
        $this->shift = Shift::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->shift->id;

        $this->generateAttendance();
    }

    public function generateAttendance()
    {
        // Ambil data attendance berdasarkan tanggal dan shift
        $attendances = Attendance::with(['reference', 'employee.position', 'employee.group.supervisor'])
            ->whereDate('shift_date', $this->date)
            ->where('shift_id', $this->shift_id)
            ->get();

        // Kelompokkan data berdasarkan divisi (group)
        $groupedAttendances = $this->groupByDivision($attendances);

        // Hitung total per kategori per divisi
        $this->attendanceData = $this->calculateTotals($groupedAttendances);
        // dd($this->attendanceData);
    }

    private function groupByDivision($attendances)
    {
        $grouped = [];

        foreach ($attendances as $attendance) {
            $division = $attendance->employee->position->name ?? '-';

            if (!isset($grouped[$division])) {
                $grouped[$division] = [];
            }

            $grouped[$division][] = $attendance;
        }

        return $grouped;
    }

    private function calculateTotals($groupedAttendances)
    {
        $attendanceData = [];

        foreach ($groupedAttendances as $position => $attendances) {
            $attendanceData[$position] = [
                'IN' => $this->calculateCategory($attendances, 'in'),
                'OUT' => $this->calculateCategory($attendances, 'out'),
                'BreakIN' => $this->calculateCategory($attendances, 'break_in'),
                'BreakOut' => $this->calculateCategory($attendances, 'break_out'),
            ];
        }

        return $attendanceData;
    }

    private function calculateCategory($attendances, $category)
    {
        $ontimeCount = 0;
        $earlyCount = 0;
        $lateCount = 0;

        // Array untuk menyimpan karyawan yang sudah diproses
        $processedEmployees = [];

        foreach ($attendances as $attendance) {
            $reference = $attendance->reference;
            if ($reference) {
                // Split waktu kategori
                $onTime = explode('-', $reference->{$category});
                $earlyTime = explode('-', $reference->{'early_' . $category});
                $lateTime = explode('-', $reference->{'late_' . $category});

                $startOnTime = Carbon::parse($onTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
                $endOnTime = Carbon::parse($onTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

                $startEarly = Carbon::parse($earlyTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
                $endEarly = Carbon::parse($earlyTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

                $startLate = Carbon::parse($lateTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
                $endLate = Carbon::parse($lateTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

                $attendanceTime = Carbon::parse($attendance->timestamp)->setDateFrom(Carbon::parse($attendance->shift_date)); // Waktu absensi karyawan

                // Cek apakah karyawan sudah diproses
                if (!in_array($attendance->employee->id, $processedEmployees)) {
                    // Cek apakah datang lebih awal (Early)
                    if ($attendanceTime->between($startEarly, $endEarly)) {
                        $earlyCount++;
                        $processedEmployees[] = $attendance->employee->id; // Tandai karyawan sudah diproses
                    }
                    // Cek apakah tepat waktu (Ontime)
                    elseif ($attendanceTime->between($startOnTime, $endOnTime)) {
                        $ontimeCount++;
                        $processedEmployees[] = $attendance->employee->id; // Tandai karyawan sudah diproses
                    }
                    // Cek apakah terlambat (Late)
                    elseif ($attendanceTime->between($startLate, $endLate)) {
                        $lateCount++;
                        $processedEmployees[] = $attendance->employee->id; // Tandai karyawan sudah diproses
                    }
                }
            }
        }

        return [
            'ontime' => $ontimeCount,
            'early' => $earlyCount,
            'late' => $lateCount,
        ];
    }

    public function showSupervisorData($category, $type, $division)
    {
        $this->selectedCategory = $category;
        $this->selectedDivision = $division;
        $this->selectedType = $type;

        // Ambil data supervisor berdasarkan kategori dan divisi
        $this->supervisorData = $this->getSupervisorData($category, $type, $division);
        // dd($this->supervisorData);
        $this->showModal = true;
    }

    private function getSupervisorData($category, $type, $division)
    {
        // Ambil data attendance berdasarkan kategori dan divisi
        $attendances = Attendance::with(['employee.group.supervisor', 'reference'])
            ->whereDate('shift_date', $this->date)
            ->where('shift_id', $this->shift_id);

        // Filter berdasarkan divisi
        if ($division != '-') {
            $attendances = $attendances->whereHas('employee.position', function ($query) use ($division) {
                $query->where('name', $division);
            });
        } else {
            $attendances = $attendances->whereHas('employee', function ($query) {
                $query->where('position_id', null);
            });
        }

        $attendances = $attendances->get();

        // Filter data berdasarkan kategori dan tipe
        $filteredAttendances = $attendances->filter(function ($attendance) use ($category, $type) {
            $reference = $attendance->reference;
            if (!$reference) {
                return false;
            }

            $onTime = explode('-', $reference->{$category});
            $earlyTime = explode('-', $reference->{'early_' . $category});
            $lateTime = explode('-', $reference->{'late_' . $category});

            $startOnTime = Carbon::parse($onTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
            $endOnTime = Carbon::parse($onTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

            $startEarly = Carbon::parse($earlyTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
            $endEarly = Carbon::parse($earlyTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

            $startLate = Carbon::parse($lateTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
            $endLate = Carbon::parse($lateTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

            $attendanceTime = Carbon::parse($attendance->timestamp)->setDateFrom(Carbon::parse($attendance->shift_date)); // Waktu absensi karyawan

            // Filter berdasarkan tipe (ontime, early, late)
            switch ($type) {
                case 'ontime':
                    return $attendanceTime->between($startOnTime, $endOnTime);
                case 'early':
                    return $attendanceTime->between($startEarly, $endEarly);
                case 'late':
                    return $attendanceTime->between($startLate, $endLate);
                default:
                    return false;
            }
        });

        // Buat data unik berdasarkan employee_id agar tidak ada duplikasi
        $uniqueAttendances = $filteredAttendances->unique('employee_id');

        // Kelompokkan data berdasarkan supervisor
        $supervisorData = [];

        foreach ($uniqueAttendances as $attendance) {
            $supervisor = $attendance->employee->group->supervisor->name ?? 'Tanpa Supervisor';

            if (!isset($supervisorData[$supervisor])) {
                $supervisorData[$supervisor] = 0;
            }

            $supervisorData[$supervisor]++;
        }

        return $supervisorData;
    }

    public function showEmployeeData($supervisor)
    {
        $this->selectedSupervisor = $supervisor;

        // Ambil data attendance berdasarkan supervisor yang dipilih
        $attendances = Attendance::with('employee')
            ->whereDate('shift_date', $this->date)
            ->where('shift_id', $this->shift_id);

        if ($this->selectedSupervisor != 'Tanpa Supervisor') {
            $attendances = $attendances->whereHas('employee.group.supervisor', function ($query) use ($supervisor) {
                $query->where('name', $supervisor);
            });
        } else {
            $attendances = $attendances->whereHas('employee', function ($query) {
                $query->where('group_id', null);
            });
        }

        if ($this->selectedDivision != '-') {
            $attendances = $attendances->whereHas('employee.position', function ($query) {
                if ($this->selectedDivision != '-') {
                    $query->where('name', $this->selectedDivision);
                }
            });
        } else {
            $attendances = $attendances->whereHas('employee', function ($query) {
                $query->where('position_id', null);
            });
        }

        $attendances = $attendances->get();

        $filteredAttendances = $attendances->filter(function ($attendance) {
            $reference = $attendance->reference;
            if (!$reference) {
                return false;
            }

            $onTime = explode('-', $reference->{$this->selectedCategory});
            $earlyTime = explode('-', $reference->{'early_' . $this->selectedCategory});
            $lateTime = explode('-', $reference->{'late_' . $this->selectedCategory});

            $startOnTime = Carbon::parse($onTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
            $endOnTime = Carbon::parse($onTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

            $startEarly = Carbon::parse($earlyTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
            $endEarly = Carbon::parse($earlyTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

            $startLate = Carbon::parse($lateTime[0])->setDateFrom(Carbon::parse($attendance->shift_date));
            $endLate = Carbon::parse($lateTime[1])->setDateFrom(Carbon::parse($attendance->shift_date));

            $attendanceTime = Carbon::parse($attendance->timestamp)->setDateFrom(Carbon::parse($attendance->shift_date)); // Waktu absensi karyawan

            // Filter berdasarkan tipe (ontime, early, late)
            switch ($this->selectedType) {
                case 'ontime':
                    return $attendanceTime->between($startOnTime, $endOnTime);
                case 'early':
                    return $attendanceTime->between($startEarly, $endEarly);
                case 'late':
                    return $attendanceTime->between($startLate, $endLate);
                default:
                    return false;
            }
        });

        // Buat data unik berdasarkan employee_id agar tidak ada duplikasi && get data attendance dan nama employeenya
        $this->employeeData = $filteredAttendances->unique('employee_id')->map(function ($attendance) {
            return [
                'name' => $attendance->employee->name,
                'phone' => $attendance->employee->phone,
                'timestamp' => $attendance->timestamp
            ];
        });

        // dd($this->employeeData);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCategory = '';
        $this->selectedDivision = '';
        $this->supervisorData = [];
        $this->selectedSupervisor = '';
        $this->employeeData = [];
    }

    #[On('updatedData')]
    public function updatedDate($date)
    {
        $this->date = $date;

        $this->dateString = Carbon::parse($date)->format('d F Y');

        $this->shift = Shift::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->shift->id;

        $this->generateAttendance();
    }

    public function render()
    {
        return view('livewire.dashboard.attendance-per-position');
    }
}
