<?php

namespace App\Livewire\MonitoringPresent;

use Livewire\Attributes\On;
use Livewire\Component;

class MonitoringPresentDetail extends Component
{
    public $monitoring_present_id;
    public $details;

    #[On('show-modal-details')]
    public function showDetail($monitoring_present_id)
    {
        $this->details = \App\Models\MonitoringPresentDetail::with('employee')->onlyActiveEmployees()->where('monitoring_present_id', $monitoring_present_id)->get();
        $this->monitoring_present_id = $monitoring_present_id;

        $this->dispatch('showModalDetails');
    }

    public function render()
    {
        return view('livewire.monitoring-present.monitoring-present-detail');
    }
}
