<?php

namespace App\Livewire\Dashboard\DashboardActivity;

use App\Models\Activity;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class DelayedActivity extends Component
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
        $this->dispatch('updateChartDelayedActivity', categories: $this->categories, data: $this->data);
    }

    public function render()
    {
        $late = Activity::late()->count();
        $on_time = Activity::onTime()->count();
        $in_progress = Activity::inProgress()->count();

        // dd($late, $on_time);

        $this->categories = ['Late', 'On Time', 'In Progress'];
        $this->data = [$late, $on_time, $in_progress];

        return view('livewire.dashboard.dashboard-activity.delayed-activity');
    }
}
