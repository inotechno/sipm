<?php

namespace App\Livewire\CategoryInventory;

use Livewire\Component;

class CategoryInventoryIndex extends Component
{
    public function render()
    {
        return view('livewire.category-inventory.category-inventory-index')->layout('layouts.app-inventory', ['title' => 'Category Inventory']);
    }
}
