<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    protected $fillable = [
        'name',
    ];

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
