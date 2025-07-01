<?php

namespace App\Livewire\ShiftEmployee;

use App\Models\Shift;
use App\Models\ShiftSchedule;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ShiftEmployeeEditShift extends Component
{
    use LivewireAlert;
    public $shifts = [];
    public $employeeID;
    public $dateSchedule;

    public $shift_id;

    #[On('editShift')]
    public function editShift($employeeId, $date)
    {
        // dd($employeeId, $date);
        $dayString = Carbon::parse($date)->format('l');
        $day = strtolower($dayString);

        $this->shifts = Shift::where('day_of_week', $day)->get();
        $this->employeeID = $employeeId;
        $this->dateSchedule = $date;

        $this->dispatch('open-modal-edit-shift');
    }

    public function updateShift()
    {
        $this->validate([
            'shift_id' => 'required',
            'dateSchedule' => 'required',
            'employeeID' => 'required',
        ]);

        try {
            $schedule = ShiftSchedule::where('employee_id', $this->employeeID)->where('date', $this->dateSchedule)->first();
            if($schedule) {
                $schedule->shift_id = $this->shift_id;
                $schedule->save();

                $this->alert('success', 'Shift berhasil diubah');
            } else {
                ShiftSchedule::create([
                    'employee_id' => $this->employeeID,
                    'shift_id' => $this->shift_id,
                    'date' => $this->dateSchedule,
                ]);

                $this->alert('success', 'Shift berhasil ditambahkan');
            }

            $this->dispatch('refreshIndex');
            $this->reset();
            $this->dispatch('close-modal-edit-shift');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.shift-employee.shift-employee-edit-shift');
    }
}
