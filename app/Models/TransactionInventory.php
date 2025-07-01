<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TransactionInventory extends Model
{
    use HasUuids;

    protected $table = 'transaction_inventories';
    protected $fillable = [
        'employee_id',
        'supervisor_id',
        'is_group',
        'group_id',
        'description',
    ];

    public function uniqueId()
    {
        return $this->id;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionInventoryDetail::class, 'transaction_inventory_id');
    }

}
