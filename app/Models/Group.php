<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'slug',
        'supervisor_id',
        'shift_id'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
