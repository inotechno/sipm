<?php

namespace App\Livewire\Employee;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EmployeeItem extends Component
{
    use LivewireAlert;
    public $employee;

    public function mount($employee)
    {
        $this->employee = $employee;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this employee?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'employee-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('employee-delete')]
    public function delete()
    {
        try {
            $this->employee->delete();
            $this->alert('success', 'User deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'User could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-item');
    }
}
