<?php

namespace App\Livewire\FileManager;

use App\Models\CategoryFile;
use Livewire\Component;

class FileManagerFolder extends Component
{
    public $slug;

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $folders = CategoryFile::all();
        return view('livewire.file-manager.file-manager-folder', compact('folders'));
    }
}
