<?php

namespace App\Livewire\Inbound;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\TransactionInventory;
use App\Models\TransactionInventoryDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class InboundForm extends BaseComponent
{
    use LivewireAlert;

    public $is_group = false;
    public $employee_id, $supervisor_id, $updated_by, $return_date;
    public $inventory_borrows = [];
    public $supervisors, $employees;
    public $selectedTransactionDetails = [];

    protected $queryString = [
        'employee_id' => ['except' => ''],
    ];

    protected $rules = [
        'selectedTransactionDetails.*.id' => 'required',
        'selectedTransactionDetails.*.quantity' => 'required',
        'is_group' => 'required',
        'employee_id' => 'required_if:is_group,false',
        'supervisor_id' => 'required_if:is_group,true',
        'updated_by' => 'required',
        'return_date' => 'required',
    ];

    protected $messages = [
        'selectedTransactionDetails.*.id.required' => 'Inventory is required',
        'selectedTransactionDetails.*.quantity.required' => 'Quantity is required',
        'is_group.required' => 'Group is required',
        'employee_id.required_if' => 'Employee is required',
        'supervisor_id.required_if' => 'Supervisor is required',
        'updated_by.required' => 'Created by is required',
        'return_date.required' => 'Return date is required',
    ];

    public function resetForm()
    {
        $this->employee_id = null;
        $this->supervisor_id = null;
        $this->inventory_borrows = [];
        $this->selectedTransactionDetails = [];
    }

    public function mount()
    {
        $this->supervisors = User::role('supervisor')->get();
        $this->employees = Employee::all();

        $this->updated_by = $this->authUser->id;
        $this->return_date = now()->format('Y-m-d');
    }

    public function updatedIsGroup($value)
    {
        $this->is_group = $value;

        $this->resetForm();
        $this->dispatch('refreshSelect2');
    }

    #[On('updateSelect2')]
    public function updatedSelect2($model, $value)
    {
        $this->resetForm();

        $this->$model = $value;

        if ($model == 'supervisor_id') {
            $this->getDataBorrowSupervisor();
        } else {
            $this->getDataBorrowEmployee();
        }

        $this->dispatch('refreshSelect2');
        $this->dispatch('$refresh');
    }

    public function selectTransaction($transaction_id)
    {
        $detail = TransactionInventoryDetail::find($transaction_id);

        // Cek apakah item sudah ada di cart
        if (isset($this->selectedTransactionDetails[$transaction_id])) {
            $this->selectedTransactionDetails[$transaction_id]['quantity']++;
        } else {
            $this->selectedTransactionDetails[$transaction_id] = [
                'id' => $detail->id,
                'transaction_id' => $detail->transaction_inventory_id,
                'inventory_id' => $detail->inventory_id,
                'name' => $detail->inventory->name,
                'quantity' => $detail->quantity,
                'borrow_date' => $detail->borrow_date,
                'return_date' => $detail->return_date,
                'condition_borrow' => $detail->condition_borrow,
                'condition_return' => $detail->condition_return,
                'note' => $detail->note,
            ];
        }

        $this->dispatch('refreshSelect2');
        $this->dispatch('refreshCart');
    }

    public function removeTransaction($transaction_id)
    {
        unset($this->selectedTransactionDetails[$transaction_id]);
        $this->dispatch('refreshCart');
    }

    public function getDataBorrowSupervisor()
    {
        $this->inventory_borrows = TransactionInventoryDetail::with('inventory', 'inventory.warehouse', 'inventory.category', 'transactionInventory')
            ->whereHas('transactionInventory', function ($query) {
                $query->where('supervisor_id', $this->supervisor_id);
            })->whereNull('return_date')->get();
    }

    public function getDataBorrowEmployee()
    {
        $this->inventory_borrows = TransactionInventoryDetail::with('inventory', 'inventory.warehouse', 'inventory.category', 'transactionInventory')
            ->whereHas('transactionInventory', function ($query) {
                $query->where('employee_id', $this->employee_id);
            })->whereNull('return_date')->get();
    }

    public function submit()
    {
        $this->validate();
        // dd($this->selectedTransactionDetails);

        try {
            DB::beginTransaction();
            $transaction_ids = collect($this->selectedTransactionDetails)->pluck('transaction_id')->unique()->toArray();

            // dd($transaction_ids);
            foreach ($this->selectedTransactionDetails as $item) {
                $transaction = TransactionInventoryDetail::find($item['id']);
                $transaction->update([
                    'return_date' => $this->return_date,
                    'condition_return' => $item['condition_return'],
                    'note' => $item['note'],
                    'updated_by' => $this->updated_by,
                ]);

                Inventory::find($item['inventory_id'])->increment('stock', $item['quantity']);
            }

            // $this->resetForm();
            $this->alert('success', 'Inbound created successfully');
            DB::commit();

            return redirect()->route('inventory.receipt.inbound', ['ids' => $transaction_ids]);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.inbound.inbound-form')->layout('layouts.app-inventory', ['title' => 'Pengembalian Barang']);
    }
}
