<?php

namespace App\Livewire\FileManager;

use App\Models\CategoryFile;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class FileManagerFormFolder extends Component
{
    use LivewireAlert;

    public $name, $icon, $color, $roles, $folder_id, $mode = 'Create';
    public $selectedRoles = [];

    public $rules = [
        'name' => 'required',
        'roles' => 'required',
    ];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->icon = '';
        $this->color = '';
        $this->selectedRoles = [];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    #[On('editFolder')]
    public function editFolder($folder_id)
    {
        // dd($folder_id);
        if ($folder_id) {
            $this->folder_id = $folder_id;
            $folder = CategoryFile::find($folder_id);
            $this->name = $folder->name;
            $this->icon = $folder->icon;
            $this->color = $folder->color;
            $this->selectedRoles = json_decode($folder->roles);
        }

        $this->mode = 'Edit';
        $this->dispatch('showModalAddFolder');
    }

    public function submitAddFolder()
    {
        $this->validate();

        try {
            $slug = Str::slug($this->name);
            $roles = json_encode($this->selectedRoles);
            // dd($roles);

            if ($this->mode == 'Edit') {
                $folder = CategoryFile::find($this->folder_id);
                $folder->update([
                    'name' => $this->name,
                    'slug' => $slug,
                    'icon' => $this->icon,
                    'color' => $this->color,
                    'roles' => $roles
                ]);

                $this->alert('success', 'Folder updated successfully');
            }else{
                $folder = CategoryFile::create([
                    'name' => $this->name,
                    'slug' => $slug,
                    'icon' => $this->icon,
                    'color' => $this->color,
                    'roles' => $roles
                ]);
            }

            $this->alert('success', 'Folder saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
            $this->dispatch('hideModalAddFolder');

            return redirect()->route('files');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.file-manager.file-manager-form-folder');
    }
}
