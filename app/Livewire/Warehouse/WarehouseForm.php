<?php

namespace App\Livewire\Warehouse;

use App\Models\Warehouse;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class WarehouseForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $slug, $warehouse;

    #[On('warehouse-edit')]
    public function edit(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
        $this->name = $warehouse->name;

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
                    Warehouse::create([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
                default:
                    $this->warehouse->update([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
            }

            $this->alert('success', 'Warehouse saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Warehouse could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->warehouse = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.warehouse.warehouse-form');
    }
}
