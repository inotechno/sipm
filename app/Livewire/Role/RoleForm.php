<?php

namespace App\Livewire\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $role;

    #[On('role-edit')]
    public function edit(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;

        $this->mode = 'edit';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        try {
            switch ($this->mode) {
                case 'create':
                    Role::create([
                        'name' => $this->name,
                    ]);
                    break;
                default:
                    $this->role->update([
                        'name' => $this->name,
                    ]);
                    break;
            }

            $this->alert('success', 'Role saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Role could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->role = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.role.role-form');
    }
}
