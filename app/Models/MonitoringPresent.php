<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class MonitoringPresent extends Model
{
    protected $table = 'monitoring_presents';

    protected $fillable = [
        'user_id',
        'shift_id',
        'datetime',
        'type',
        'group_id',
        'role',
        'shift_date',
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'shift_date' => 'date'
    ];

    protected function roleName(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst($this->role),
        );
    }

    protected function totalPresent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->details()->where('is_present', 1)->count(),
        );
    }

    protected function totalAbsent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->details()->where('is_present', 0)->where('reason', 'tanpa_keterangan')->count(),
        );
    }

    protected function totalTraining(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->details()->where('reason', 'training')->count(),
        );
    }

    protected function totalSick(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->details()->where('reason', 'sakit')->count(),
        );
    }

    protected function totalLeave(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->details()->where('reason', 'cuti')->count(),
        );
    }

    protected function totalMoveSupervisor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->details()->where('reason', 'pindah_supervisor')->count(),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function details()
    {
        return $this->hasMany(MonitoringPresentDetail::class, 'monitoring_present_id', 'id');
    }
}
