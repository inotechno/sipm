<?php

namespace App\Livewire\MonitoringPresent;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class MonitoringPresentItem extends Component
{
    use LivewireAlert;
    
    public $monitoring_present;

    public function mount($monitoring_present)
    {
        $this->monitoring_present = $monitoring_present;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this monitoring?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'monitoring-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('monitoring-delete')]
    public function delete()
    {
        try {
            $this->monitoring_present->delete();
            $this->alert('success', 'Monitoring deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Monitoring could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.monitoring-present.monitoring-present-item');
    }
}
