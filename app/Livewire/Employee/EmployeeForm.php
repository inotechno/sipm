<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EmployeeForm extends Component
{
    use LivewireAlert;
    public $name, $email, $employee_id, $phone, $group, $position, $positions, $shift, $groups, $mode = 'create';
    public $employee;

    protected $rules = [
        'employee_id' => 'required',
        'name' => 'required',
        'email' => 'nullable|email',
        'position' => 'nullable',
        'group' => 'nullable',
        'shift' => 'required|between:1,2'
    ];

    protected $messages = [
        'employee_id.required' => 'ID harus diisi',
        'email.unique' => 'Email sudah digunakan',
        'name.required' => 'Nama harus diisi',
        'email.email' => 'Email tidak valid',
        'shift.required' => 'Shift harus diisi',
        'shift.between' => 'Shift harus antara 1 dan 2'
    ];

    public function mount()
    {
        $this->positions = \App\Models\Position::all();
        $this->groups = \App\Models\Group::all();
    }

    #[On('employee-edit')]
    public function edit($employee_id)
    {
        $employee = Employee::find($employee_id);
        $this->employee = $employee;
        $this->name = $employee->name;
        $this->employee_id = $employee->id;
        $this->email = $employee->email;
        $this->group = $employee->group_id;
        $this->position = $employee->position_id;
        $this->phone = $employee->phone;
        $this->shift = $employee->shift;

        $this->mode = 'edit';
    }

    public function submit()
    {
        $this->validate();

        try {
            switch ($this->mode) {
                case 'create':
                    $employee = Employee::create([
                        'id' => $this->employee_id,
                        'name' => $this->name,
                        'email' => $this->email,
                        'phone' => $this->phone,
                        'position_id' => $this->position,
                        'group_id' => $this->group,
                        'shift' => $this->shift
                    ]);

                    break;
                case 'edit':
                    $this->employee->update([
                        'id' => $this->employee_id,
                        'name' => $this->name,
                        'email' => $this->email,
                        'phone' => $this->phone,
                        'position_id' => $this->position,
                        'group_id' => $this->group,
                        'shift' => $this->shift
                    ]);

                    break;
            }

            $this->alert('success', 'Employee ' . ($this->mode == 'create' ? 'created' : 'updated') . ' successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset('name', 'email', 'phone', 'group', 'position', 'employee_id', 'shift');
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.employee.employee-form');
    }
}
