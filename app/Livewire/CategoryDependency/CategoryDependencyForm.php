<?php

namespace App\Livewire\CategoryDependency;

use App\Models\CategoryDependency;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryDependencyForm extends Component
{
    use LivewireAlert;

    public $mode = 'create';
    public $name, $slug, $category_dependency;

    #[On('category_dependency-edit')]
    public function edit(CategoryDependency $category_dependency)
    {
        $this->category_dependency = $category_dependency;
        $this->name = $category_dependency->name;

        $this->mode = 'edit';
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $this->slug = Str::slug($this->name);

        try {
            switch ($this->mode) {
                case 'create':
                    CategoryDependency::create([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
                default:
                    $this->category_dependency->update([
                        'name' => $this->name,
                        'slug' => $this->slug,
                    ]);
                    break;
            }

            $this->alert('success', 'Category Dependency saved successfully');
            $this->resetForm();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', 'Category Dependency could not be saved');
        }
    }

    public function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->category_dependency = null;
        $this->mode = 'create';
    }

    public function render()
    {
        return view('livewire.category-dependency.category-dependency-form');
    }
}
