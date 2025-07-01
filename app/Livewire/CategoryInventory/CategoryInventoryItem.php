<?php

namespace App\Livewire\CategoryInventory;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryInventoryItem extends Component
{
    use LivewireAlert;

    public $category;

    public function mount($category)
    {
        $this->category = $category;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this category?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'category' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'category-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('category-delete')]
    public function delete()
    {
        try {
            $this->category->delete();
            $this->alert('success', 'Category Inventory deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Category Inventory could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.category-inventory.category-inventory-item');
    }
}
