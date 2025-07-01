<?php

namespace App\Livewire\Inventory;

use App\Models\CategoryInventory;
use App\Models\Inventory;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class InventoryForm extends Component
{
    use LivewireAlert;

    public $name, $category_id, $warehouse_id, $serial_number, $unit, $stock, $purchase_date, $condition, $price, $description, $mode, $image_path, $image_url, $type;
    public $categories, $warehouses;
    public $items = [];

    protected $rules = [
        'name' => 'required',
        'category_id' => 'required',
        'warehouse_id' => 'required',
        'stock' => 'required',
        'unit' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Name is required',
        'category_id.required' => 'Category is required',
        'warehouse_id.required' => 'Warehouse is required',
        'stock.required' => 'Stock is required',
        'unit.required' => 'Unit is required',
    ];

    public function submit()
    {
        try {
            foreach ($this->items as $item) {
                Inventory::create($item);
            }

            $this->resetForm();
            $this->alert('success', 'Inventory created successfully');
        } catch (\Exception $e) {
            $this->alert('error', 'Inventory could not be created');
        }

        // dd($this->items);
    }

    public function resetForm()
    {
        $this->name = '';
        $this->category_id = '';
        $this->warehouse_id = '';
        $this->serial_number = '';
        $this->unit = '';
        $this->stock = '';
        $this->purchase_date = '';
        $this->condition = '';
        $this->price = '';
        $this->type = '';
        $this->description = '';

        $this->items = [];

        $this->mode = 'create';
    }

    public function addItem()
    {
        $this->validate();

        $this->items[] = [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'warehouse_id' => $this->warehouse_id,
            'serial_number' => $this->serial_number,
            'category_name' => CategoryInventory::find($this->category_id)->name,
            'warehouse_name' => Warehouse::find($this->warehouse_id)->name,
            'purchase_date' => $this->purchase_date,
            'unit' => $this->unit,
            'stock' => $this->stock,
            'condition' => $this->condition,
            'price' => $this->price,
            'description' => $this->description,
            'type' => $this->type
        ];

        $this->reset(['name', 'category_id', 'warehouse_id', 'serial_number', 'purchase_date', 'unit', 'stock', 'condition', 'price', 'description', 'type']);
    }

    public function editItem($index)
    {
        $this->name = $this->items[$index]['name'];
        $this->category_id = $this->items[$index]['category_id'];
        $this->warehouse_id = $this->items[$index]['warehouse_id'];
        $this->serial_number = $this->items[$index]['serial_number'];
        $this->purchase_date = $this->items[$index]['purchase_date'];
        $this->unit = $this->items[$index]['unit'];
        $this->stock = $this->items[$index]['stock'];
        $this->condition = $this->items[$index]['condition'];
        $this->price = $this->items[$index]['price'];
        $this->description = $this->items[$index]['description'];
        $this->type = $this->items[$index]['type'];

        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function mount($id = null)
    {
        $this->resetForm();
        if ($id) {
            $this->mode = 'edit';
        }

        $this->categories = CategoryInventory::all();
        $this->warehouses = Warehouse::all();
    }

    public function render()
    {
        return view('livewire.inventory.inventory-form')->layout('layouts.app-inventory', ['title' => 'Inventory Create']);
    }
}
