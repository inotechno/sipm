<?php

namespace App\Livewire\ShiftEmployee;

use Livewire\Component;

class ShiftEmployeeIndex extends Component
{
    public function render()
    {
        return view('livewire.shift-employee.shift-employee-index')->layout('layouts.app', ['title' => 'Shift Employee']);
    }
}
