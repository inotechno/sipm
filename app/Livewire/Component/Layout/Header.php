<?php

namespace App\Livewire\Component\Layout;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends BaseComponent
{
    public $user;
    public $name;
    public $avatar;

    public function mount()
    {
        $this->user = $this->authUser;
        $this->name = $this->user->name;
        $this->avatar = $this->user->avatar_url;
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.component.layout.header');
    }
}
