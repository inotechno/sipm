<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shifts';

    protected $fillable = ['name', 'start_time', 'break_start_time', 'break_end_time', 'end_time', 'day_of_week', 'start_adjustment', 'end_adjustment'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'shift_schedules', 'shift_id', 'employee_id');
    }

    public function schedule()
    {
        return $this->hasMany(ShiftSchedule::class);
    }

    public function schedules()
    {
        return $this->hasManyThrough(ShiftSchedule::class, Employee::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }
}
