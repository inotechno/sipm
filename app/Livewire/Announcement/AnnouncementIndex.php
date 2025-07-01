<?php

namespace App\Livewire\Announcement;

use Livewire\Component;

class AnnouncementIndex extends Component
{
    public function render()
    {
        return view('livewire.announcement.announcement-index')->layout('layouts.app', ['title' => 'Announcement Management']);
    }
}
