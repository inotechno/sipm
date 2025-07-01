<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryDependency extends Model
{
    protected $table = 'category_dependencies';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function activityIssues()
    {
        return $this->hasMany(ActivityIssue::class, 'category_dependency_id');
    }
}
