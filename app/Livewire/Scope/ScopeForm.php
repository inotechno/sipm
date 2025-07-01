<?php

namespace App\Livewire\Scope;

use App\Models\Scope;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ScopeForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $slug, $scope;

    #[On('scope-edit')]
    public function edit(Scope $scope)
    {
        $this->scope = $scope;
        $this->name = $scope->name;

        $this->mode = 'edit';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $this->slug = Str::slug($this->name);

        try {
            switch ($this->mode) {
                case 'create':
                    Scope::create([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
                default:
                    $this->scope->update([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
            }

            $this->alert('success', 'Scope saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Scope could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->scope = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.scope.scope-form');
    }
}
