<?php

namespace App\Livewire\Permission;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class PermissionItem extends Component
{
    use LivewireAlert;

    public $permission;

    public function mount($permission)
    {
        $this->permission = $permission;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this permission?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'permission' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'permission-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('permission-delete')]
    public function delete()
    {
        try {
            $this->permission->delete();
            $this->alert('success', 'Role deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Role could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.permission.permission-item');
    }
}
