<?php

namespace App\Livewire\Group;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class GroupItem extends Component
{
    use LivewireAlert;

    public $group;

    public function mount($group)
    {
        $this->group = $group;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this group?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'group-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('group-delete')]
    public function delete()
    {
        try {
            $this->group->delete();
            $this->alert('success', 'Group deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Group could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.group.group-item');
    }
}
