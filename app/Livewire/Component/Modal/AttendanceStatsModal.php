<?php

namespace App\Livewire\Component\Modal;

use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendanceStatsModal extends Component
{
    public $modal_id = '';
    public $modal_title = '';

    public $items = [];
    public $groups = [];
    public $filteredItems = []; // Data yang sudah difilter
    public $searchName = ''; // Properti untuk pencarian nama

    public $filterGroup = null;
    public $count = 0;
    public $countGroups = [];

    public function mount()
    {
        $this->groups = Group::with('supervisor')->get();
    }

    public function updatedFilterGroup()
    {
        $this->applyFilters();
    }

    public function updatedSearchName()
    {
        $this->applyFilters();
    }

    protected function applyFilters()
    {
        $this->filteredItems = $this->items;

        // Filter by group
        if ($this->filterGroup) {
            $this->filteredItems = array_filter($this->filteredItems, function ($item) {
                return $item['group_id'] == $this->filterGroup;
            });
        }

        // Filter by name
        if ($this->searchName) {
            $this->filteredItems = array_filter($this->filteredItems, function ($item) {
                return stripos($item['name'], $this->searchName) !== false;
            });
        }

        // Hitung jumlah data
        $this->count = count($this->filteredItems);
    }

    #[On('open-modal')]
    public function openModal($modal_id, $modal_title, $data = [])
    {
        $this->modal_id = $modal_id;
        $this->modal_title = $modal_title;
        $this->items = $data;

        // dd($this->items);
        $this->applyFilters();
        $this->dispatch('showModal');
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.component.modal.attendance-stats-modal');
    }
}
