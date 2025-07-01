<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class MonitoringPresentDetail extends Model
{
    protected $table = 'monitoring_present_details';

    protected $fillable = ['monitoring_present_id', 'employee_id', 'is_present', 'note', 'reason', 'move_supervisor_id'];

    public function monitoringPresent()
    {
        return $this->belongsTo(MonitoringPresent::class, 'monitoring_present_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeOnlyActiveEmployees($query)
    {
        return $query->whereHas('employee', function ($query) {
            $query->whereNull('deleted_at');
        });
    }

    public function moveSupervisor()
    {
        return $this->belongsTo(User::class, 'move_supervisor_id', 'id');
    }
}
