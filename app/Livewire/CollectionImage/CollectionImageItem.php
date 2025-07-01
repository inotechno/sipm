<?php

namespace App\Livewire\CollectionImage;

use App\Models\CollectionImage;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class CollectionImageItem extends Component
{
    use LivewireAlert;

    public $group;

    public function mount($group)
    {
        $this->group = $group;
    }

    public function confirmDelete()
    {
        $this->alert('warning', 'Are you sure you want to delete this daily images?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'showDenyButton' => true,
            'denyButtonText' => 'No, cancel!',
            'timer' => null,
            'toast' => false,
            'position' => 'center',
            'timerProgressBar' => true,
            'onConfirmed' => 'daily-image-delete',
            'onDenied' => 'cancelled',
        ]);
    }

    #[On('daily-image-delete',)]
    public function delete()
    {
        try {
            $collection_images = CollectionImage::where('user_id', $this->group['user_id'])
            ->whereDate('created_at', $this->group['date'])->get();

            foreach ($collection_images as $collection_image) {
                // Remove the image file from storage
                Storage::disk('public')->delete($collection_image->path);
                $collection_image->delete();
            }

            $this->alert('success', 'Daily Image deleted successfully');
            return redirect()->route('collection.images');
        } catch (\Exception $e) {
            $this->alert('error', 'Daily Image could not be deleted');
        }
    }

    public function render()
    {
        return view('livewire.collection-image.collection-image-item');
    }
}
