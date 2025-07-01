<?php

namespace App\Livewire\Dashboard\DashboardActivity;

use App\Models\Activity;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActivityByStatus extends Component
{
    #[Reactive()]
    public $startDate;

    #[Reactive()]
    public $endDate;

    public $categories = [];
    public $data = [];

    #[On('reloadChart')]
    public function reloadChart()
    {
        $this->dispatch('updateChartActivityStatus', categories: $this->categories, data: $this->data);
    }

    public function render()
    {
        // Data untuk Pie Chart (Aktivitas per Status)
        $activitiesByStatus = Activity::with('status')->groupBy('status_id')
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->selectRaw('status_id, COUNT(*) as total')
            ->get()
            ->pluck('total', 'status.name');

        $this->categories = $activitiesByStatus->keys();
        $this->data = $activitiesByStatus->values();

        return view('livewire.dashboard.dashboard-activity.activity-by-status');
    }
}
