<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CollectionImage extends Model
{
    protected $table = 'collection_images';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'title',
        'path',
        'url',
        'size',
        'ext',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
