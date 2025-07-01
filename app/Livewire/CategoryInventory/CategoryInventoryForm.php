<?php

namespace App\Livewire\CategoryInventory;

use App\Models\CategoryInventory;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryInventoryForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $slug, $category;

    #[On('category-edit')]
    public function edit(CategoryInventory $category)
    {
        $this->category = $category;
        $this->name = $category->name;

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
                    CategoryInventory::create([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
                default:
                    $this->category->update([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
            }

            $this->alert('success', 'Category Inventory saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Category Inventory could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->category = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.category-inventory.category-inventory-form');
    }
}
