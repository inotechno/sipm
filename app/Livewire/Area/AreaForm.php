<?php

namespace App\Livewire\Area;

use App\Models\Area;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AreaForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $slug, $area;

    #[On('area-edit')]
    public function edit(Area $area)
    {
        $this->area = $area;
        $this->name = $area->name;

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
                    Area::create([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
                default:
                    $this->area->update([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
            }

            $this->alert('success', 'Area saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Area could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->area = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.area.area-form');
    }
}
