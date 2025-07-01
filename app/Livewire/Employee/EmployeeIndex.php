<?php

namespace App\Livewire\Employee;

use Livewire\Component;

class EmployeeIndex extends Component
{
    public function render()
    {
        return view('livewire.employee.employee-index')->layout('layouts.app', ['title' => 'Employee']);
    }
}
