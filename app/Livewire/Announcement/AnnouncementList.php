<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use Livewire\Component;

use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AnnouncementList extends Component
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]
    public $search = '';
    public $perPage = 30;


    public function render()
    {
        $announcements = Announcement::with('author', 'recipients')->where('subject', 'like', '%' . $this->search . '%')->paginate($this->perPage);
        return view('livewire.announcement.announcement-list', compact('announcements'));
    }
}
