<?php

namespace App\Livewire\Inventory;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class InventoryItem extends Component
{
    #[Reactive()]
    public $inventory;

    public function render()
    {
        return view('livewire.inventory.inventory-item');
    }
}
