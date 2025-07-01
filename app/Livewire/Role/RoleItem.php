<?php

namespace App\Livewire\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class RoleItem extends Component
{
    use LivewireAlert;

    public $role;

    public function mount($role)
    {
        $this->role = $role;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this role?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'role' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'role-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('role-delete')]
    public function delete()
    {
        try {
            $this->role->delete();
            $this->alert('success', 'Role deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Role could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.role.role-item');
    }
}
