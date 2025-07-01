<?php

namespace App\Livewire\Position;

use App\Models\Position;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class PositionForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $position;

    #[On('position-edit')]
    public function edit(Position $position)
    {
        $this->position = $position;
        $this->name = $position->name;

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
                    Position::create([
                        'name' => $this->name,
                    ]);
                    break;
                default:
                    $this->position->update([
                        'name' => $this->name,
                    ]);
                    break;
            }

            $this->alert('success', 'Position saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Position could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->position = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.position.position-form');
    }
}
