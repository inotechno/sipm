<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'subject',
        'description',
        'user_id',
    ];

    public function getDescriptionPreviewAttribute()
    {
        return substr($this->description, 0, 50) . '...';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke penerima pengumuman
    public function recipients()
    {
        return $this->hasMany(AnnouncementRecipient::class);
    }
}
