<?php

namespace App\Livewire\Scope;

use Livewire\Component;

class ScopeIndex extends Component
{
    public function render()
    {
        return view('livewire.scope.scope-index')->layout('layouts.app', ['title' => 'Scope Management']);
    }
}
