<?php

namespace App\Livewire\Position;

use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EmployeeAddedPosition extends Component
{
    use LivewireAlert;

    public $employees;
    public $selectedEmployees = [];
    public $position_id;
    public $search = '';
    public $number = 0;
    public $limit = 20;
    public $offset = 0;
    public $loadMore = false;

    public function mount()
    {
        $this->employees = Employee::where('position_id', null)->limit($this->limit)->offset($this->offset)->get();
        if (count($this->employees) < $this->limit) {
            $this->loadMore = false;
        } else {
            $this->loadMore = true;
        }
    }

    #[On('show-form-add-position')]
    public function showModalAddGroup($position_id)
    {
        $this->selectedEmployees = [];

        $this->position_id = $position_id;
        $employees = Employee::select('id', 'name')->where('position_id', $this->position_id)->get();

        foreach ($employees as $employee) {
            $this->selectedEmployees[$this->number]['id'] = $employee['id'];
            $this->selectedEmployees[$this->number]['name'] = $employee['name'];
            $this->number++;
        }

        $this->dispatch('open-modal-add-position');
    }

    #[On('close-form-add-position')]
    public function closeModalAddGroup()
    {
        $this->selectedEmployees = [];
        $this->number = 0;
        $this->search = '';
        $this->group_id = '';

        $this->dispatch('close-modal-add-position');
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
                unset($this->selectedEmployees[$key]);
            }
        }
    }

    public function loadMore()
    {
        $this->offset += $this->limit;
        $newEmployees = Employee::where('position_id', null)
            ->where('name', 'like', '%' . $this->search . '%')
            ->limit($this->limit)
            ->offset($this->offset)
            ->get();

        $this->employees = $this->employees->merge($newEmployees);
    }

    public function updatedSearch()
    {
        $this->offset = 0;
        $this->employees = Employee::where('position_id', null)->where('name', 'like', '%' . $this->search . '%')->limit($this->limit)->offset($this->offset)->get();
    }

    public function submitInsertMultiple()
    {
        $this->validate([
            'selectedEmployees.*.id' => 'required|exists:employees,id',
        ]);

        try {
            $employeeIDs = array_column($this->selectedEmployees, 'id');
            Employee::whereIn('id', $employeeIDs)->update(['position_id' => $this->position_id]);
            $this->dispatch('close-modal-add-position');
            $this->alert('success', 'Successfully added employees');
            return redirect(route('master.positions'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.position.employee-added-position');
    }
}
