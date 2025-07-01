<?php

namespace App\Livewire\Profile;

use Livewire\Component;

class ProfileIndex extends Component
{
    public function render()
    {
        return view('livewire.profile.profile-index')->layout('layouts.app', ['title' => 'User Profile']);
    }
}
