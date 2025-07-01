<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    use HasFactory;
    
    protected $fillable = ['activity_id','scope_id','progress'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function historyProgress()
    {
        return $this->hasMany(ActivityProgress::class);
    }
}
