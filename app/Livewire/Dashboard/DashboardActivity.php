<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class DashboardActivity extends Component
{
    public $startDate;
    public $endDate;

    public function filterDate()
    {
        $this->dispatch('reloadChart');
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-activity')->layout('layouts.app', ['title' => 'Dashboard Activity']);
    }
}
