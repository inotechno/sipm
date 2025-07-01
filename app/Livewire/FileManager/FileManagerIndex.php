<?php

namespace App\Livewire\FileManager;

use Livewire\Component;

class FileManagerIndex extends Component
{
    public $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }
    public function render()
    {
        return view('livewire.file-manager.file-manager-index')->layout('layouts.app', [
            'title' => 'File Manager'
        ]);
    }
}
