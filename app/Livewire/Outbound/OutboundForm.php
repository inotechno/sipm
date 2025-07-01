<?php

namespace App\Livewire\Outbound;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Inventory;
use App\Models\TransactionInventory;
use App\Models\TransactionInventoryDetail;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OutboundForm extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]

    public $search = '';
    public $perPage = 30;
    public $groups, $employees;

    public $supervisor_id, $group_id, $employee_id, $is_group = false, $condition, $borrow_date, $description, $created_by;
    public array $selectedInventories = [];

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $rules = [
        'selectedInventories.*.id' => 'required',
        'selectedInventories.*.quantity' => 'required',
        'is_group' => 'required',
        'employee_id' => 'required_if:is_group,false',
        'group_id' => 'required_if:is_group,true',
        'created_by' => 'required',
        'borrow_date' => 'required',
    ];

    protected $messages = [
        'selectedInventories.*.id.required' => 'Inventory is required',
        'selectedInventories.*.quantity.required' => 'Quantity is required',
        'is_group.required' => 'Group is required',
        'employee_id.required_if' => 'Employee is required',
        'group_id.required_if' => 'Group is required',
        'created_by.required' => 'Created by is required',
        'borrow_date.required' => 'Borrow date is required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->search = '';
        $this->inventory_id = null;
        $this->supervisor_id = null;
        $this->group_id = null;
        $this->employee_id = null;
        $this->quantity = null;
        $this->is_group = false;
        $this->condition = null;
        $this->borrow_date = null;
        $this->description = null;

        $this->selectedInventories = [];

        $this->dispatch('refreshSelect2');
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

    public function mount()
    {
        $this->groups = Group::with('supervisor')->get();
        $this->employees = Employee::get();

        $this->created_by = $this->authUser->id;
    }

    public function updatedIsGroup($value)
    {
        if ($value) {
            $this->employee_id = null; // Reset employee jika group dipilih
        } else {
            $this->group_id = null; // Reset group jika tidak memilih group
        }

        $this->dispatch('refreshSelect2');
    }

    #[On('updateSelect2')]
    public function updatedSelect2($model, $value)
    {
        $this->$model = $value;

        if ($model == 'group_id') {
            $this->employee_id = null;

            $group = Group::find($value);
            $this->supervisor_id = $group->supervisor_id;
        }

        $this->dispatch('refreshSelect2');
    }

    public function selectInventory($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);

        if (!$inventory)
            return;

        // Cek apakah item sudah ada di cart
        if (isset($this->selectedInventories[$inventoryId])) {
            $this->selectedInventories[$inventoryId]['quantity']++;
        } else {
            $this->selectedInventories[$inventoryId] = [
                'id' => $inventory->id,
                'name' => $inventory->name,
                'serial_number' => $inventory->serial_number,
                'stock' => $inventory->stock,
                'unit' => $inventory->unit,
                'quantity' => 1,
            ];
        }

        $this->dispatch('refreshSelect2');
        $this->dispatch('refreshCart');
    }

    public function removeInventory($inventoryId)
    {
        unset($this->selectedInventories[$inventoryId]);
        $this->dispatch('refreshCart');
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $transaction = TransactionInventory::create([
                'employee_id' => $this->employee_id,
                'supervisor_id' => $this->supervisor_id,
                'is_group' => $this->is_group,
                'group_id' => $this->group_id,
                'description' => $this->description,
            ]);

            foreach ($this->selectedInventories as $item) {
                if ($item['quantity'] > $item['stock']) {
                    return $this->alert('error', 'Quantity is greater than stock');
                }

                TransactionInventoryDetail::create([
                    'transaction_inventory_id' => $transaction->id,
                    'borrow_date' => $this->borrow_date,
                    'created_by' => $this->created_by,
                    'inventory_id' => $item['id'],
                    'quantity' => $item['quantity'],
                ]);

                Inventory::find($item['id'])->decrement('stock', $item['quantity']);
            }

            // $this->resetForm();
            $this->alert('success', 'Outbound created successfully');
            DB::commit();

            return redirect()->route('inventory.receipt', ['uuid' => $transaction->id]);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function render()
    {
        $inventories = Inventory::with('category', 'warehouse', 'outbounds')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')->orWhere('serial_number', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.outbound.outbound-form', compact('inventories'))->layout('layouts.app-inventory', ['title' => 'Peminjaman Barang']);
    }
}
