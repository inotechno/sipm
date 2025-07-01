<?php

namespace App\Livewire\Dashboard\DashboardActivity;

use App\Models\ActivityIssue;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ActivityIssueResolved extends Component
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
        $this->dispatch('updateChartIssueResolved', categories: $this->categories, data: $this->data);
    }

    public function render()
    {
        $solved = ActivityIssue::solved()->count();
        $unsolved = ActivityIssue::unsolved()->count();

        $this->categories = ['Solved', 'Unsolved'];
        $this->data = [$solved, $unsolved];

        return view('livewire.dashboard.dashboard-activity.activity-issue-resolved');
    }
}
