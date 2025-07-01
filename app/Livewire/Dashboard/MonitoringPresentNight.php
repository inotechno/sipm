<?php

namespace App\Livewire\Dashboard;

use App\Models\MonitoringPresent;
use App\Models\Shift;
use Carbon\Carbon;
use Livewire\Component;

class MonitoringPresentNight extends Component
{ 
    public $date;
    public $type;
    public $shift_id;
    public $shift;
    public $dateString;

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
        $this->shift = Shift::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->skip(1)->first();
        $this->shift_id = $this->shift->id;
        $this->type = 'in_break';

        $this->dateString = Carbon::parse($this->date)->format('d F Y');
    }

    public function render()
    {
        // Ambil data tanpa grouping
        $monitoring_presents = MonitoringPresent::with('shift', 'user', 'group.supervisor', 'details')
            ->whereDate('datetime', $this->date)
            ->where('shift_id', $this->shift_id)
            ->where('type', $this->type)
            ->get()
            ->groupBy('group_id');

        return view('livewire.dashboard.monitoring-present-night', [
            'monitoring_presents' => $monitoring_presents
        ]);
    }
}
