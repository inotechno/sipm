<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryInventory extends Model
{
    protected $table = 'category_inventories';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'category_id');
    }
}
