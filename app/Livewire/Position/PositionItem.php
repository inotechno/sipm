<?php

namespace App\Livewire\Position;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class PositionItem extends Component
{
    use LivewireAlert;

    public $position;

    public function mount($position)
    {
        $this->position = $position;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this position?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'position-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('position-delete')]
    public function delete()
    {
        try {
            $this->position->delete();
            $this->alert('success', 'Position deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Position could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.position.position-item');
    }
}
