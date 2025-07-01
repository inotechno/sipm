<?php

namespace App\Livewire\User;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class UserItem extends Component
{
    use LivewireAlert;

    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this user?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'user-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('user-delete')]
    public function delete()
    {
        try {
            $this->user->delete();
            $this->alert('success', 'User deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'User could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.user.user-item');
    }
}
