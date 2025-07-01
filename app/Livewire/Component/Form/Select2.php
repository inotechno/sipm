<?php

namespace App\Livewire\Component\Form;

use Livewire\Attributes\On;
use Livewire\Component;

class Select2 extends Component
{
    public $label = '';
    public $options = [];
    public $selected = [];
    public $placeholder = 'Select an option';
    public $model;
    public $width = '100%';
    public $multiple = false;
    public $dropdownParent;

    protected $listeners = ['updateSelect2'];

    public function mount($model, $options = [], $selected = [], $placeholder = 'Select an option', $multiple = false, $width = '100%', $dropdownParent = null)
    {
        $this->width = $width;
        $this->model = $model;
        $this->options = $options;
        $this->selected = is_array($selected) ? $selected : [$selected]; // Pastikan array
        $this->placeholder = $placeholder;
        $this->multiple = $multiple;
        $this->dropdownParent = $dropdownParent;
    }

    public function updateSelect2($model, $value)
    {
        $decodedValue = json_decode($value, true); // Decode JSON ke array

        // Update hanya model yang sedang dipilih
        if ($this->model === $model) {
            $this->selected = is_array($decodedValue) ? $decodedValue : [$decodedValue];

            // Dispatch event hanya untuk model terkait
            $this->dispatch($model . 'Selected', value: $this->selected);
        }
    }

    #[On('reset-select2')]
    public function resetSelected()
    {
        $this->selected = [];
        $this->dispatch('$commit');
    }

    public function render()
    {
        return view('livewire.component.form.select2');
    }
}
