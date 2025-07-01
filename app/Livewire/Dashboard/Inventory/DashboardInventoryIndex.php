<?php

namespace App\Livewire\Dashboard\Inventory;

use Livewire\Component;

class DashboardInventoryIndex extends Component
{
    public function render()
    {
        return view('livewire.dashboard.inventory.dashboard-inventory-index')->layout('layouts.app-inventory', ['title' => 'Dashboard Inventory']);
    }
}
