<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
    ];

    public function scopeOnlyActiveEmployees($query)
    {
        return $query->whereHas('employees', function ($query) {
            $query->whereNull('deleted_at');
        });
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
