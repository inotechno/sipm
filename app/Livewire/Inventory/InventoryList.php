<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryList extends Component
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]

    public $search = '';
    public $perPage = 30;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function handleRefresh()
    {
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function resetFilter()
    {
        $this->search = "";
        $this->resetPage();
    }

    public function render()
    {
        $inventories = Inventory::with('category', 'warehouse')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')->orWhere('serial_number', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.inventory.inventory-list', compact('inventories'));
    }
}
