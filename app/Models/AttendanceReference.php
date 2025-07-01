<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceReference extends Model
{
    protected $table = 'attendance_references';

    protected $fillable = ['name', 'start_time', 'break_start_time', 'break_end_time', 'end_time', 'day_of_week', 'start_adjustment', 'end_adjustment'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
