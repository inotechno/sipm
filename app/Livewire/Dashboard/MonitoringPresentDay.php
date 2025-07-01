<?php

namespace App\Livewire\Dashboard;

use App\Models\MonitoringPresent;
use App\Models\Shift;
use Carbon\Carbon;
use Livewire\Component;

class MonitoringPresentDay extends Component
{
    public $date;
    public $type;
    public $shift_id;
    public $shift;
    public $dateString;

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
        $this->shift = Shift::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->shift->id;
        $this->type = 'in';

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

        // dd($monitoring_presents);

        return view('livewire.dashboard.monitoring-present-day', [
            'monitoring_presents' => $monitoring_presents
        ]);
    }
}
