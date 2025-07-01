<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityEmployee extends Model
{
    protected $table = 'activity_employees';

    protected $fillable = [
        'activity_id',
        'employee_id',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
