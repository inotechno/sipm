<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementRecipient extends Model
{
    protected $table = 'announcement_recipients';

    protected $fillable = [
        'announcement_id',
        'recipient_id',
        'recipient_type',
        'name',
        'phone',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function recipient()
    {
        return $this->morphTo();
    }
}
