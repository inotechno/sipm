<?php

namespace App\Livewire\Dashboard\DashboardActivity;

use App\Models\Activity;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActivityByArea extends Component
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
        $this->dispatch('updateChartActivityArea', categories: $this->categories, data: $this->data);
    }

    public function render()
    {
        $activitiesByArea = Activity::with('area')->groupBy('area_id')
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->selectRaw('area_id, COUNT(*) as total')
            ->get()
            ->pluck('total', 'area.name');

        $this->categories = $activitiesByArea->keys();
        $this->data = $activitiesByArea->values();

        return view('livewire.dashboard.dashboard-activity.activity-by-area');
    }
}
