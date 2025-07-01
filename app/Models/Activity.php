<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'scope_id',
        'area_id',
        'position_id',
        'total_estimate',
        'forecast_date',
        'plan_date',
        'actual_date',
        'supervisor_id',
        'description',
        'status_id',
        'change_to_activity_id',
        'total_quantity',
    ];

    public function getProgressColorAttribute()
    {
        if ($this->progress == 0) {
            return 'danger';
        } else if ($this->progress < 50) {
            return 'warning';
        } else {
            return 'success';
        }
    }

    // Scope untuk aktivitas yang selesai tepat waktu
    public function scopeOnTime(Builder $query)
    {
        return $query->whereNotNull('actual_date')->whereColumn('actual_date', '<=', 'forecast_date');
    }

    // Scope untuk aktivitas yang terlambat
    public function scopeLate(Builder $query)
    {
        return $query->whereNotNull('actual_date')->whereColumn('actual_date', '>', 'forecast_date');
    }

    // Scope untuk aktivitas yang masih berjalan
    public function scopeInProgress(Builder $query)
    {
        return $query->whereNull('actual_date');
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class);
    }

    public function issues()
    {
        return $this->hasMany(ActivityIssue::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusActivity::class, 'status_id');
    }

    public function historyProgress()
    {
        return $this->hasMany(ActivityProgress::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'activity_employees', 'activity_id', 'employee_id');
    }

    public function changeToActivity()
    {
        return $this->belongsTo(Activity::class, 'change_to_activity_id');
    }
}
