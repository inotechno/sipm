<?php

namespace App\Livewire\Activity;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityIndex extends Component
{


    public function render()
    {
        return view('livewire.activity.activity-index')->layout('layouts.app', ['title' => 'Activity']);
    }
}
