<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityIssue extends Model
{
    protected $fillable = [
        'date',
        'activity_id',
        'category_dependency_id',
        'description',
        'solution',
        'percentage_dependency',
        'percentage_solution',
        'resolved_at',
        'notified_site_manager_count',
        'last_notified_site_manager_at',
        'notified_project_manager_count',
        'last_notified_project_manager_at',
        'notified_project_director_count',
        'last_notified_project_director_at',
    ];

    public function scopeSolved($query)
    {
        return $query->whereNotNull('resolved_at');
    }

    public function scopeUnsolved($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function categoryDependency()
    {
        return $this->belongsTo(CategoryDependency::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
