<?php

namespace App\Livewire\Dashboard;

use App\Models\Shift;
use Carbon\Carbon;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $date;
    public $shifts;
    public $shift_id;

    protected $listeners = ['refreshIndex', '$refresh'];

    public function mount()
    {
        $this->date =Carbon::today()->format('Y-m-d');
    }

    public function updatedDate($value)
    {
        $this->dispatch('updatedData', $this->date);
    }

    public function updatedShiftId($value)
    {
        $this->dispatch('updatedData', $this->date);
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
