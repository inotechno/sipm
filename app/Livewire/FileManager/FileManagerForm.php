<?php

namespace App\Livewire\FileManager;

use App\Livewire\BaseComponent;
use App\Models\CategoryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileManagerForm extends BaseComponent
{
    use WithFileUploads, LivewireAlert;

    public $selectCategory;
    public $name;
    public $file;
    public $categories;

    public function mount($slug = null)
    {
        $this->categories = CategoryFile::where(function ($query) {
            foreach ($this->authUser->roles as $role) {
                $query->orWhereJsonContains('roles', $role->name);
            }
        })->get();

        if ($slug != null) {
            $this->selectCategory = CategoryFile::where('slug', $slug)->first()->id;
        }
    }

    public function resetForm()
    {
        $this->name = null;
        $this->file = null;
    }

    #[On('selectCategorySelected')]
    public function selectCategorySelected($value)
    {
        $this->selectCategory = $value;
    }

    public function submitAddFile()
    {
        $this->validate([
            'name' => 'required',
            'file' => 'required',
            'selectCategory' => 'required|exists:category_files,id',
        ]);

        try {
            $category = CategoryFile::whereIn('id', $this->selectCategory)->first();
            $hash = md5_file($this->file->getRealPath());
            $file_name = $hash . '.' . $this->file->getClientOriginalExtension();

            $path = $this->file->storeAs(path: $category->name, name: $file_name, options: 'gcs');
            $url = Storage::disk('gcs')->url($path);

            $data = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'path' => $path,
                'category_id' => $this->selectCategory,
                'size' => $this->file->getSize(),
                'url' => $url,
                'ext' => $this->file->getClientOriginalExtension(),
                'mime_type' => $this->file->getMimeType(),
                'uploaded_by' => $this->authUser->id,
                'visibility' => 'public',
                'hash' => $hash,
                'metadata' => json_encode([
                    'original_name' => $this->file->getClientOriginalName(),
                    'mime_type' => $this->file->getMimeType(),
                    'size' => $this->file->getSize(),
                    'path' => $path,
                    'url' => $url,
                    'hash' => $hash,
                    'disk' => 'gcs',
                    'category' => $category->name,
                    'category_id' => $category->id,
                    'extension' => $this->file->getClientOriginalExtension(),
                ]),
            ];

            // dd($data);
            $category->files()->create($data);
            $this->alert('success', 'File uploaded successfully');

            $this->dispatch('refreshIndex');
            $this->dispatch('hideModalAddFile');
            $this->resetForm();
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.file-manager.file-manager-form');
    }
}
