<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'name',
        'email',
        'position_id',
        'group_id',
        'phone',
        'shift'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function schedules()
    {
        return $this->hasMany(ShiftSchedule::class);
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_employees', 'employee_id', 'activity_id');
    }

    public function announcementRecipients()
    {
        return $this->morphMany(AnnouncementRecipient::class, 'recipient');
    }
}
