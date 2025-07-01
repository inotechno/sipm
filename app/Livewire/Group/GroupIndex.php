<?php

namespace App\Livewire\Group;

use Livewire\Component;

class GroupIndex extends Component
{
    public function render()
    {
        return view('livewire.group.group-index')->layout('layouts.app', ['title' => 'Group Management']);
    }
}
