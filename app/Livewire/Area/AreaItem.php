<?php

namespace App\Livewire\Area;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AreaItem extends Component
{
    use LivewireAlert;

    public $area;

    public function mount($area)
    {
        $this->area = $area;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this area?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'area' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'area-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('area-delete')]
    public function delete()
    {
        try {
            $this->area->delete();
            $this->alert('success', 'Area deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Area could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.area.area-item');
    }
}
