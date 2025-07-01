<?php

namespace App\Livewire\CategoryDependency;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryDependencyItem extends Component
{
    use LivewireAlert;

    public $category_dependency;

    public function mount($category_dependency)
    {
        $this->category_dependency = $category_dependency;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this category?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'category_dependency' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'category_dependency-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('category_dependency-delete')]
    public function delete()
    {
        try {
            $this->category_dependency->delete();
            $this->alert('success', 'Category Dependency deleted successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Category Dependency could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.category-dependency.category-dependency-item');
    }
}
