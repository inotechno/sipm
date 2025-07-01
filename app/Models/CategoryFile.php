<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFile extends Model
{
    use SoftDeletes;
    protected $table = 'category_files';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'icon',
        'color',
        'name',
        'slug',
        'roles',
        'created_at',
        'updated_at'
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'category_id');
    }

    // Get Total Size
    public function getTotalSizeAttribute()
    {
        return $this->files()->sum('size');
    }

    public function getFormattedSizeAttribute()
    {
        $size = $this->totalSize;

        if ($size >= 1073741824) { // 1 GB
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) { // 1 MB
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) { // 1 KB
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' B'; // Byte
        }
    }

    public function getFilesCountAttribute()
    {
        return $this->files()->count();
    }

}
