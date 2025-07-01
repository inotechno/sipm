<?php

namespace App\Livewire\User;

use App\Livewire\BaseComponent;
use App\Models\User;use Livewire\Attributes\Url;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends BaseComponent
{
    public function render()
    {
        return view('livewire.user.user-index')->layout('layouts.app', ['title' => 'User Management']);
    }
}
