<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TransactionInventoryDetail extends Model
{
    use HasUuids;
    protected $table = 'transaction_inventory_details';

    protected $fillable = [
        'transaction_inventory_id',
        'inventory_id',
        'quantity',
        'borrow_date',
        'return_date',
        'created_by',
        'updated_by',
        'condition_borrow',
        'condition_return',
        'note',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
    ];

    public function uniqueId()
    {
        return $this->id;
    }

    public function transactionInventory()
    {
        return $this->belongsTo(TransactionInventory::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
