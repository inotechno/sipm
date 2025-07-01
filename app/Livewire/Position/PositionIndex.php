<?php

namespace App\Livewire\Position;

use Livewire\Component;

class PositionIndex extends Component
{
    public function render()
    {
        return view('livewire.position.position-index')->layout('layouts.app', ['title' => 'Position Management']);
    }
}
