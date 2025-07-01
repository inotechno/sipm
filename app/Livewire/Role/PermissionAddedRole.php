<?php

namespace App\Livewire\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionAddedRole extends Component
{
    use LivewireAlert;

    public $role;
    public $permissions;
    public $selectedPermissions = [];
    public $role_id;
    public $search = '';
    public $number = 0;
    public $limit = 20;
    public $offset = 0;
    public $loadMore = false;

    public function mount()
    {
        $this->permissions = Permission::limit($this->limit)->offset($this->offset)->get();
        if (count($this->permissions) < $this->limit) {
            $this->loadMore = false;
        } else {
            $this->loadMore = true;
        }
    }

    #[On('show-form-add-role')]
    public function showModalAddGroup($role_id)
    {
        $this->selectedPermissions = [];

        $this->role_id = $role_id;
        $this->role = Role::where('id', $role_id)->first();
        $permissions = $this->role->permissions->toArray();

        foreach ($permissions as $permission) {
            $this->selectedPermissions[$this->number]['id'] = $permission['id'];
            $this->selectedPermissions[$this->number]['name'] = $permission['name'];
            $this->number++;
        }

        $this->dispatch('open-modal-add-role');
    }

    #[On('close-form-add-role')]
    public function closeModalAddGroup()
    {
        $this->selectedPermissions = [];
        $this->number = 0;
        $this->search = '';
        $this->group_id = '';

        $this->dispatch('close-modal-add-role');
    }

    public function addPermission($permission_id, $permission_name)
    {
        $this->selectedPermissions[$this->number]['id'] = $permission_id;
        $this->selectedPermissions[$this->number]['name'] = $permission_name;

        $this->number++;
    }

    public function removePermission($permission_id)
    {
        foreach ($this->selectedPermissions as $key => $selectedPermission) {
            if ($selectedPermission['id'] == $permission_id) {
                unset($this->selectedPermissions[$key]);
            }
        }
    }

    public function showMore()
    {
        $this->offset += $this->limit;
        // dd($this->offset);
        $newPermissions = Permission::where('name', 'like', '%' . $this->search . '%')
            ->limit($this->limit)
            ->offset($this->offset)
            ->get();

        $this->permissions = $this->permissions->merge($newPermissions);
    }

    public function updatedSearch()
    {
        $this->offset = 0;
        $this->permissions = Permission::where('name', 'like', '%' . $this->search . '%')
            ->limit($this->limit)
            ->offset($this->offset)
            ->get();
    }

    public function submitInsertMultiple()
    {
        $this->validate([
            'selectedPermissions.*.id' => 'required|exists:permissions,id',
        ]);

        try {
            $permissionIDs = array_column($this->selectedPermissions, 'id');
            $this->role->permissions()->sync($permissionIDs);
            $this->dispatch('close-modal-add-role');
            $this->alert('success', 'Successfully added permissions');
            return redirect(route('master.roles'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.role.permission-added-role');
    }
}
