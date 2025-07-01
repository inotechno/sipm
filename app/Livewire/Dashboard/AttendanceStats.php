<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\AttendanceReference;
use Livewire\Attributes\On;

class AttendanceStats extends Component
{
    public $totalIN = 0;
    public $totalBreakIn = 0;
    public $totalBreakOut = 0;
    public $totalOUT = 0;
    public $date;
    public $dateString;
    public $shift_id;
    public $reference;

    public $employees_in = [];
    public $employees_break_in = [];
    public $employees_break_out = [];
    public $employees_out = [];
    public $employees_early_in = [];
    public $employees_late_in = [];
    public $employees_ontime_in = [];
    public $employees_early_break_in = [];
    public $employees_late_break_in = [];
    public $employees_ontime_break_in = [];
    public $employees_early_break_out = [];
    public $employees_late_break_out = [];
    public $employees_ontime_break_out = [];
    public $employees_early_out = [];
    public $employees_late_out = [];
    public $employees_ontime_out = [];

    public $totalin = [];
    public $totalbreak_in = [];
    public $totalbreak_out = [];
    public $totalout = [];
    public $totalInWithoutOut = [];
    public $totalOutWithoutIn = [];

    public $title_in = [];
    public $title_break_in = [];
    public $title_break_out = [];
    public $title_out = [];

    public function mount($date)
    {
        $this->date = $date;
        $this->dateString = Carbon::parse($date)->format('d F Y');
        $this->reference = AttendanceReference::where('day_of_week', strtolower(string: Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->reference->id;
        // dd($this->date, $this->shift_id, $this->reference, $this->shift_id);

        $this->calculateAttendance();
    }

    #[On('updatedData')]
    public function updatedDate($date)
    {
        $this->date = $date;

        $this->dateString = Carbon::parse($date)->format('d F Y');

        $this->reference = AttendanceReference::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->reference->id;
        // dd($this->date, $this->shift_id, $this->reference, $this->shift_id);
        $this->calculateAttendance();
    }

    public function calculateAttendance()
    {
        // dd($this->date);
        // Ambil data attendance berdasarkan tanggal
        $attendances = Attendance::with(['reference', 'employee.group', 'employee.position'])
            ->whereDate('shift_date', $this->date)
            ->where('shift_id', $this->shift_id)
            ->get();

        // dd($attendances);
        // Reset data
        $this->employees_in = [];
        $this->employees_break_in = [];
        $this->employees_break_out = [];
        $this->employees_out = [];
        $this->employees_early_in = [];
        $this->employees_late_in = [];
        $this->employees_ontime_in = [];
        $this->employees_early_break_in = [];
        $this->employees_late_break_in = [];
        $this->employees_ontime_break_in = [];
        $this->employees_early_break_out = [];
        $this->employees_late_break_out = [];
        $this->employees_ontime_break_out = [];
        $this->employees_early_out = [];
        $this->employees_late_out = [];
        $this->employees_ontime_out = [];

        // Proses setiap kategori
        $this->totalIN = $this->calculateCategory($attendances, 'in');
        $this->totalBreakIn = $this->calculateCategory($attendances, 'break_in');
        $this->totalBreakOut = $this->calculateCategory($attendances, 'break_out');
        $this->totalOUT = $this->calculateCategory($attendances, 'out');

        // dd($this->employees_in);
        $this->dispatch('updateGapAttendance', $this->employees_in, $this->employees_out);
        $this->dispatch('refreshIndex');
    }

    private function calculateCategory($attendances, $category)
    {
        $ontimeCount = 0;
        $earlyCount = 0;
        $lateCount = 0;

        // Array untuk menyimpan karyawan yang sudah diproses
        $processedEmployees = [];
        $employeesData = [];

        $startOnTime = null;
        $endOnTime = null;
        $startEarly = null;
        $endEarly = null;
        $startLate = null;
        $endLate = null;

        $onTime = explode('-', $this->reference->{$category});
        $earlyTime = explode('-', $this->reference->{'early_' . $category});
        $lateTime = explode('-', $this->reference->{'late_' . $category});

        $startOnTime = Carbon::parse($onTime[0])->setDateFrom(Carbon::parse($this->date));
        $endOnTime = Carbon::parse($onTime[1])->setDateFrom(Carbon::parse($this->date));

        $startEarly = Carbon::parse($earlyTime[0])->setDateFrom(Carbon::parse($this->date));
        $endEarly = Carbon::parse($earlyTime[1])->setDateFrom(Carbon::parse($this->date));

        $startLate = Carbon::parse($lateTime[0])->setDateFrom(Carbon::parse($this->date));
        $endLate = Carbon::parse($lateTime[1])->setDateFrom(Carbon::parse($this->date));

        // dd($attendances->take(1));
        foreach ($attendances as $attendance) {
            $reference = $attendance->reference;
            if ($reference) {
                $attendanceTime = Carbon::parse($attendance->timestamp)->setDateFrom(Carbon::parse($attendance->shift_date)); // Waktu absensi karyawan
                $timestamp = Carbon::parse($attendance->timestamp)->format('d F Y H:i');
                // Cek apakah karyawan sudah diproses
                if (!in_array($attendance->employee->id, $processedEmployees)) {
                    // Cek apakah datang lebih awal (Early)
                    if ($attendanceTime->between($startEarly, $endEarly)) {
                        $attendance->employee->timestamp = $timestamp;
                        $this->{"employees_early_" . $category}[] = $attendance->employee->toArray();
                        $earlyCount++;
                        $processedEmployees[] = $attendance->employee->id; // Tandai karyawan sudah diproses
                    }
                    // Cek apakah tepat waktu (Ontime)
                    elseif ($attendanceTime->between($startOnTime, $endOnTime)) {
                        $attendance->employee->timestamp = $timestamp;
                        $this->{"employees_ontime_" . $category}[] = $attendance->employee->toArray();
                        $ontimeCount++;
                        $processedEmployees[] = $attendance->employee->id; // Tandai karyawan sudah diproses
                    }
                    // Cek apakah terlambat (Late)
                    elseif ($attendanceTime->between($startLate, $endLate)) {
                        $attendance->employee->timestamp = $timestamp;
                        $this->{"employees_late_" . $category}[] = $attendance->employee->toArray();
                        $lateCount++;
                        $processedEmployees[] = $attendance->employee->id; // Tandai karyawan sudah diproses
                    }
                }
            }
        }

        // Menghitung total untuk kategori
        $this->{"total" . $category} = [
            'ontime' => $ontimeCount,
            'early' => $earlyCount,
            'late' => $lateCount
        ];

        $this->{"employees_" . $category} = array_merge($this->{"employees_ontime_" . $category}, $this->{"employees_early_" . $category}, $this->{"employees_late_" . $category});

        $this->{"title_" . $category} = [
            'ontime' => 'Total ' . strtoupper($category) . ' (On Time ' . $startOnTime?->format('H:i') . '-' . $endOnTime?->format('H:i') . ')',
            'early' => 'Total ' . strtoupper($category) . ' (Early ' . $startEarly?->format('H:i') . '-' . $endEarly?->format('H:i') . ')',
            'late' => 'Total ' . strtoupper($category) . ' (Late ' . $startLate?->format('H:i') . '-' . $endLate?->format('H:i') . ')',
        ];

        // \Log::info('Siang: ' . json_encode($this->{"title_" . $category}));
        return $ontimeCount + $earlyCount + $lateCount;
    }

    public function openModal($modal_id, $modal_title, $data)
    {
        $this->dispatch('open-modal', modal_id: $modal_id, modal_title: $modal_title, data: $this->{$data});
    }

    public function render()
    {
        return view('livewire.dashboard.attendance-stats');
    }
}
