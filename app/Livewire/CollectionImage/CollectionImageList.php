<?php

namespace App\Livewire\CollectionImage;

use App\Livewire\BaseComponent;
use App\Models\CollectionImage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CollectionImageList extends BaseComponent
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $supervisors;
    public $filterDate, $filterSupervisor;
    public $perPage = 10;

    public function mount()
    {
        $this->supervisors = User::role('supervisor')->get();
    }

    public function filter()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function resetFilter()
    {
        $this->filterDate = null;
        $this->filterSupervisor = null;
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $collectionImages = CollectionImage::with('supervisor')
            ->when($this->filterDate, fn($query) => $query->whereDate('created_at', $this->filterDate))
            ->when($this->filterSupervisor, fn($query) => $query->where('user_id', $this->filterSupervisor))
            ->orderBy('created_at', 'desc');  // Paginate 10 items per page

        if ($this->authUser->hasRole('Supervisor')) {
            $collectionImages->where('user_id', $this->authUser->id);
        }

        $collectionImages = $collectionImages->get();
        // dd($collectionImages);
        // Grouping by user_id and date, and format for the Blade view
        $groupedImages = $collectionImages->groupBy(function ($item) {
            return $item->user_id . '|' . $item->created_at->toDateString();
        })->map(function ($images, $key) {
            [$userId, $date] = explode('|', $key);
            $supervisor = $images->first()->supervisor;

            return [
                'user_id' => $userId,
                'user_name' => $supervisor->name ?? 'Unknown User',
                'upload_date' => \Carbon\Carbon::parse($date)->format('d M Y'),
                'images' => $images,
                'date' => \Carbon\Carbon::parse($date)->format('Y-m-d'),
            ];
        });

        // Ubah hasil group menjadi Collection untuk pagination
        $paginatedGroups = $this->paginate($groupedImages, $this->perPage); // 5 grup per halaman

        return view('livewire.collection-image.collection-image-list', [
            'groupedImages' => $paginatedGroups,
        ]);
    }

    // Fungsi untuk mem-paginate Collection
    protected function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage();
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
