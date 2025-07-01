<?php

namespace App\Livewire\Permission;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $permission;

    #[On('permission-edit')]
    public function edit(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;

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
                    Permission::create([
                        'name' => $this->name,
                    ]);
                    break;
                default:
                    $this->permission->update([
                        'name' => $this->name,
                    ]);
                    break;
            }

            $this->alert('success', 'Permission saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Permission could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->permission = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.permission.permission-form');
    }
}
