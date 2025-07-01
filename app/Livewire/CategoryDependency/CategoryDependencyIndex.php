<?php

namespace App\Livewire\CategoryDependency;

use Livewire\Component;

class CategoryDependencyIndex extends Component
{
    public function render()
    {
        return view('livewire.category-dependency.category-dependency-index')->layout('layouts.app', ['title' => 'Category Dependency']);
    }
}
