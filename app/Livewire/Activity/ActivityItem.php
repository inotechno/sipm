<?php

namespace App\Livewire\Activity;

use App\Models\StatusActivity;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityItem extends Component
{
    use LivewireAlert;

    public $activity;
    public $number;
    public $activity_id;
    public $colors;

    public function mount($activity, $number)
    {
        $this->activity = $activity;
        $this->number = $number;

        if ($this->activity->progress == 0) {
            $this->colors = 'rgb(179, 44, 20)';
        } elseif ($this->activity->progress < 50) {
            $this->colors = 'rgb(255, 166, 0)';
        } else {
            $this->colors = 'rgb(15, 134, 10)';
        }

        $this->dispatch('reloadChart');
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this activity?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'position' => 'center',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'activity' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'activity-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('activity-delete')]
    public function delete()
    {
        try {
            $this->activity->delete();
            $this->alert('success', 'Activity deleted successfully');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            $this->alert('error', 'Activity could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.activity.activity-item');
    }
}
