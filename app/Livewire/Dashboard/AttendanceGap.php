<?php

namespace App\Livewire\Dashboard;

use App\Models\Attendance;
use App\Models\AttendanceReference;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendanceGap extends Component
{
    public $date;
    public $shift_id;
    public $dateString;
    public $reference;
    public $employees_in = [];
    public $employees_out = [];

    public $gapCheckInOnly = []; // Karyawan yang check-in tetapi tidak check-out
    public $gapCheckOutOnly = []; // Karyawan yang check-out tetapi tidak check-in
    public $totalGapCheckInOnly = 0;
    public $totalGapCheckOutOnly = 0;

    public function mount($date)
    {
        $this->date = $date;
        $this->dateString = Carbon::parse($date)->format('d F Y');
        $this->reference = AttendanceReference::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->reference->id;
    }

    #[On('updateGapAttendance')]
    public function updateGapAttendance($employees_in, $employees_out)
    {
        $this->employees_in = $employees_in;
        $this->employees_out = $employees_out;
        $this->calculateGap();
    }

    #[On('updatedData')]
    public function updatedDate($date)
    {
        $this->date = $date;
        $this->dateString = Carbon::parse($date)->format('d F Y');
        $this->reference = AttendanceReference::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->reference->id;
    }

    public function calculateGap()
    {
        // Reset data sebelumnya
        $this->gapCheckInOnly = [];
        $this->gapCheckOutOnly = [];
        $this->totalGapCheckInOnly = 0;
        $this->totalGapCheckOutOnly = 0;

        // Ambil daftar ID dari employees_in dan employees_out
        $employeesInIds = array_column($this->employees_in, 'id');
        $employeesOutIds = array_column($this->employees_out, 'id');

        // Cek karyawan yang hanya check-in tanpa check-out
        foreach ($this->employees_in as $employee) {
            if (!in_array($employee['id'], $employeesOutIds)) {
                $this->gapCheckInOnly[] = $employee;
            }
        }

        // Cek karyawan yang hanya check-out tanpa check-in
        foreach ($this->employees_out as $employee) {
            if (!in_array($employee['id'], $employeesInIds)) {
                $this->gapCheckOutOnly[] = $employee;
            }
        }

        // Hitung total gap
        $this->totalGapCheckInOnly = count($this->gapCheckInOnly);
        $this->totalGapCheckOutOnly = count($this->gapCheckOutOnly);
    }

    public function openModal($modal_id, $modal_title, $data)
    {
        $this->dispatch('open-modal', modal_id: $modal_id, modal_title: $modal_title, data: $this->{$data});
    }

    public function render()
    {
        return view('livewire.dashboard.attendance-gap');
    }
}
