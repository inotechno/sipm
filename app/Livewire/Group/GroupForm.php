<?php

namespace App\Livewire\Group;

use App\Models\Group;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;

class GroupForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $slug, $group, $supervisor_id;
    public $supervisors;

    public function mount()
    {
        $this->supervisors = User::role('supervisor')->get();
    }

    #[On('group-edit')]
    public function edit(Group $group)
    {
        $this->group = $group;
        $this->name = $group->name;
        $this->supervisor_id = $group->supervisor_id;

        $this->mode = 'edit';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'supervisor_id' => 'required',
        ]);

        $this->slug = Str::slug($this->name);

        try {
            switch ($this->mode) {
                case 'create':
                    Group::create([
                        'name' => $this->name,
                        'slug' => $this->slug,
                        'supervisor_id' => $this->supervisor_id
                    ]);
                    break;
                default:
                    $this->group->update([
                        'name' => $this->name,
                        'slug' => $this->slug,
                        'supervisor_id' => $this->supervisor_id
                    ]);
                    break;
            }

            $this->alert('success', 'Group saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->group = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.group.group-form');
    }
}
