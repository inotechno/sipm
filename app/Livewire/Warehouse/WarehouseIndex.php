<?php

namespace App\Livewire\Warehouse;

use Livewire\Component;

class WarehouseIndex extends Component
{
    public function render()
    {
        return view('livewire.warehouse.warehouse-index')->layout('layouts.app-inventory', ['title' => 'Warehouse List']);
    }
}
