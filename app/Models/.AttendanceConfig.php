<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceConfig extends Model
{
    protected $table = 'attendance_configs';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'sequence',
    ];
}
