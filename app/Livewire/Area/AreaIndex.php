<?php

namespace App\Livewire\Area;

use Livewire\Component;

class AreaIndex extends Component
{
    public function render()
    {
        return view('livewire.area.area-index')->layout('layouts.app', ['title' => 'Area']);
    }
}
