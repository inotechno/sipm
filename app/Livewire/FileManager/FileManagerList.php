<?php

namespace App\Livewire\FileManager;

use App\Livewire\BaseComponent;
use App\Models\CategoryFile;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class FileManagerList extends BaseComponent
{
    use LivewireAlert;

    public $slug, $folder;
    public $files = [];
    public $folders = [];

    public $folder_name;
    public $file;

    protected $listeners = [
        'refreshIndex' => '$refresh',
        'loadFolderFiles' => 'loadFolderFiles', // Event listener untuk memuat file
    ];

    public function mount($slug = null)
    {
        $this->slug = $slug;

        if ($this->slug == null) {
            // Query untuk mengambil kategori yang cocok dengan salah satu role user
            $this->folders = CategoryFile::where(function ($query) {
                foreach ($this->authUser->roles as $role) {
                    $query->orWhereJsonContains('roles', $role->name);
                }
            })->get();
            // dd($this->folders->totalSize);
        } else {
            $this->loadFolderFiles($this->slug);
        }
    }

    public function loadFolderFiles($slug)
    {
        $this->slug = $slug;
        $this->folder = CategoryFile::with('files')->where('slug', $this->slug)->first();

        if ($this->folder) {
            $this->folder_name = $this->folder->name;
            $this->files = $this->folder->files;
        } else {
            $this->folder_name = null;
            $this->files = [];
        }

        $this->dispatch('change-url', $this->slug);
    }

    public function confirmDelete(CategoryFile $folder)
    {
        $this->alert('warning', 'Menghapus folder akan menghapus semua file di dalamnya?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes',
            'cancelButtonText' => 'No',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'deleteFolder',
            'allowOutsideClick' => false,
        ]);

        $this->folder = $folder;
    }

    #[On('deleteFolder')]
    public function deleteFolder()
    {
        foreach ($this->folder->files as $file) {
            // Storage::disk('gcs')->delete($file->path);
            $file->delete();
        }

        $this->folder->delete();
        $this->alert('success', 'Folder deleted successfully');
        $this->dispatch('refreshIndex');
        return redirect()->route('files');
    }

    public function downloadFile(File $file)
    {
        $file->download_count++;
        $file->save();

        return Storage::disk('gcs')->download($file->path);
    }

    public function confirmRemoveFile(File $file)
    {
        $this->alert('warning', 'Are you sure you want to delete this file?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'removeFile',
            'onDenied' => 'cancelled',
        ]);

        $this->file = $file;
    }

    #[On('removeFile')]
    public function removeFile()
    {
        // Storage::disk('gcs')->delete($this->file->path);
        $this->file->delete();

        $this->alert('success', 'File deleted successfully');
        $this->dispatch('refreshIndex');

        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.file-manager.file-manager-list');
    }
}
