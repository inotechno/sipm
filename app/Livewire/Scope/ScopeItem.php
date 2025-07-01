<?php

namespace App\Livewire\Scope;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ScopeItem extends Component
{
    use LivewireAlert;

    public $scope;

    public function mount($scope)
    {
        $this->scope = $scope;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this scope?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'scope' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'scope-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('scope-delete')]
    public function delete()
    {
        try {
            $this->scope->delete();
            $this->alert('success', 'Scope deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Scope could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.scope.scope-item');
    }
}
