<?php

namespace App\Livewire\Group;

use App\Models\Employee;
use App\Models\Group;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EmployeeAddedGroup extends Component
{
    use LivewireAlert;

    public $employees;
    public $selectedEmployees = [];
    public $group_id;
    public $search = '';
    public $number = 0;
    public $limit = 20;
    public $offset = 0;
    public $removeEmployees = [];

    public function mount()
    {
        $this->employees = Employee::where('group_id', null)->limit($this->limit)->offset($this->offset)->get();
    }

    #[On('show-form-add-group')]
    public function showModalAddGroup($group_id)
    {
        $this->group_id = $group_id;
        $group = Group::find($group_id);

        foreach ($group->employees as $employee) {  
            $this->addEmployee($employee->id, $employee->name);
        }

        $this->dispatch('open-modal-add-group');
    }

    #[On('close-form-add-group')]
    public function closeModalAddGroup()
    {
        $this->selectedEmployees = [];
        $this->number = 0;
        $this->search = '';
        $this->group_id = '';

        $this->dispatch('close-modal-add-group');
    }

    public function addEmployee($employee_id, $employee_name)
    {
        $this->selectedEmployees[$this->number]['id'] = $employee_id;
        $this->selectedEmployees[$this->number]['name'] = $employee_name;

        $this->number++;
    }

    public function removeEmployee($employee_id)
    {
        foreach ($this->selectedEmployees as $key => $selectedEmployee) {
            if ($selectedEmployee['id'] == $employee_id) {
                $this->removeEmployees[] = $employee_id;
                unset($this->selectedEmployees[$key]);
            }
        }
    }

    public function loadMore()
    {
        $this->offset += $this->limit;
        $newEmployees = Employee::where('group_id', null)
            ->where('name', 'like', '%' . $this->search . '%')
            ->limit($this->limit)
            ->offset($this->offset)
            ->get();

        $this->employees = $this->employees->merge($newEmployees);
    }

    public function updatedSearch()
    {
        $this->offset = 0;
        $this->employees = Employee::where('group_id', null)->where('name', 'like', '%' . $this->search . '%')->limit($this->limit)->offset($this->offset)->get();
    }

    public function submitInsertMultiple()
    {
        $this->validate([
            'selectedEmployees.*.id' => 'required|exists:employees,id',
        ]);

        try {
            $removeEmployeeIDs = $this->removeEmployees;
            $employeeIDs = array_column($this->selectedEmployees, 'id');
            
            Employee::whereIn('id', $removeEmployeeIDs)->update(['group_id' => null]);
            Employee::whereIn('id', $employeeIDs)->update(['group_id' => $this->group_id]);
            $this->dispatch('close-modal-add-group');
            $this->alert('success', 'Successfully added employees');
            return redirect(route('master.groups'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.group.employee-added-group');
    }
}
