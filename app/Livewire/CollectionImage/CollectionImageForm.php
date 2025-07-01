<?php

namespace App\Livewire\CollectionImage;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Livewire\BaseComponent;
use App\Models\CollectionImage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CollectionImageForm extends BaseComponent
{
    use WithFileUploads, LivewireAlert;

    public $title, $user_id, $image, $path, $url, $size, $ext;
    public $previewImage = 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg';

    protected $rules = [
        'title' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    protected $messages = [
        'image.required' => 'Gambar wajib diisi',
        'image.image' => 'File harus berupa gambar',
        'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg',
        'image.max' => 'Ukuran gambar maksimal 2MB',
        'title.required' => 'Judul wajib diisi',
    ];

    public function mount()
    {
        $this->user_id =  $this->authUser->id;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedImage()
    {
        $this->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        $this->previewImage = $this->image->temporaryUrl();
    }

    public function store()
    {
        $this->validate();

        try {
            $uid = Str::uuid();

            $name = $uid . '.' . $this->image->getClientOriginalExtension();
            $this->path = $this->image->storeAs('collection-image', $name, 'public');
            $this->url = asset('storage/' . $this->path);
            $this->size = $this->image->getSize();
            $this->ext = $this->image->getClientOriginalExtension();

            $collectionImage = CollectionImage::create([
                'title' => $this->title,
                'user_id' => $this->user_id,
                'path' => $this->path,
                'url' => $this->url,
                'size' => $this->size,
                'ext' => $this->ext,
            ]);

            $this->alert('success', 'Daily Image Created Successfully', [
                'position' => 'center',
            ]);

            return redirect()->route('collection.images');
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage(), [
                'position' => 'center',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.collection-image.collection-image-form');
    }
}
