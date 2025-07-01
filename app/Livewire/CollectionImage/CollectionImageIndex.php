<?php

namespace App\Livewire\CollectionImage;

use Livewire\Component;

class CollectionImageIndex extends Component
{
    public function render()
    {
        return view('livewire.collection-image.collection-image-index')->layout('layouts.app', [
            'title' => 'Collection Images'
        ]);
    }
}
