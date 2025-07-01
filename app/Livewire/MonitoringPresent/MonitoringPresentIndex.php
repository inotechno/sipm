<?php

namespace App\Livewire\MonitoringPresent;

use Livewire\Component;

class MonitoringPresentIndex extends Component
{
    public function render()
    {
        return view('livewire.monitoring-present.monitoring-present-index')->layout('layouts.app', ['title' => 'Monitoring Present']);
    }
}
