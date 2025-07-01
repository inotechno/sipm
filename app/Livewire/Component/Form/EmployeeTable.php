<?php

namespace App\Livewire\Component\Form;

use App\Models\Employee;
use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class EmployeeTable extends Component
{
    public $filterSearch;
    public $filterGroup;
    public $selectedEmployees = [];

    #[On('updateSelectedEmployees')]
    public function updateSelectedEmployees($selectedEmployees)
    {
        $this->selectedEmployees = $selectedEmployees;
    }

    #[On('setFilterGroup')]
    public function setFilterGroup($groupId)
    {
        $this->filterGroup = $groupId;
    }
    
    public function render()
    {
        $employees = Employee::with('group')->when($this->filterSearch, function ($query) {
            $query->where('name', 'like', '%' . $this->filterSearch . '%');
        })->when($this->filterGroup, function ($query) {
            $query->where('group_id', $this->filterGroup);
        })->get();

        $groups = Group::all();

        return view('livewire.component.form.employee-table', compact('employees', 'groups'));
    }
}
