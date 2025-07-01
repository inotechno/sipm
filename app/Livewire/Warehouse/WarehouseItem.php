<?php

namespace App\Livewire\Warehouse;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class WarehouseItem extends Component
{
    use LivewireAlert;

    public $warehouse;

    public function mount($warehouse)
    {
        $this->warehouse = $warehouse;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this warehouse?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'warehouse' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'warehouse-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('warehouse-delete')]
    public function delete()
    {
        try {
            $this->warehouse->delete();
            $this->alert('success', 'Warehouse deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Warehouse could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.warehouse.warehouse-item');
    }
}
