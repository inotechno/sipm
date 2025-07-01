<?php

namespace App\Livewire\Inventory;

use App\Models\CategoryInventory;
use App\Models\Warehouse;
use Livewire\Component;

class InventoryFilter extends Component
{
    public $categories, $warehouses;

    public function mount()
    {
        $this->categories = CategoryInventory::all();
        $this->warehouses = Warehouse::all();
    }

    public function render()
    {
        return view('livewire.inventory.inventory-filter');
    }
}
