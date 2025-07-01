<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;
    protected $table = 'inventories';

    protected $fillable = [
        'name',
        'category_id',
        'warehouse_id',
        'serial_number',
        'purchase_date',
        'condition',
        'stock',
        'unit',
        'price',
        'image_path',
        'image_url',
        'type',
        'description',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryInventory::class, 'category_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function transactions()
    {
        return $this->hasMany(TransactionInventoryDetail::class);
    }

    public function outbounds()
    {
        return $this->hasMany(TransactionInventoryDetail::class)->where('return_date', null);
    }

    public function inbounds()
    {
        return $this->hasMany(TransactionInventoryDetail::class)->whereNotNull('return_date');
    }

}
