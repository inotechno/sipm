<?php

namespace App\Livewire\Dashboard\DashboardActivity;

use App\Models\ActivityIssue;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActivityIssueByArea extends Component
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
        $this->dispatch('updateChartIssueArea', categories: $this->categories, data: $this->data);
    }

    public function render()
    {
        $averageDependencyByArea = ActivityIssue::when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        })
            ->join('activities', 'activities.id', '=', 'activity_issues.activity_id')
            ->join('areas', 'areas.id', '=', 'activities.area_id')
            ->groupBy('activities.area_id', 'areas.name')
            ->selectRaw('areas.name as area_name, COUNT(activity_issues.id) as total')
            ->get()
            ->pluck('total', 'area_name');

        $this->categories = $averageDependencyByArea->keys();
        $this->data = $averageDependencyByArea->values();
        // dd($averageDependencyByArea);
        return view('livewire.dashboard.dashboard-activity.activity-issue-by-area');
    }
}
