<?php

namespace App\Livewire\Group;

use App\Livewire\BaseComponent;
use App\Models\Group;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class GroupList extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]

    public $search = '';
    public $perPage = 30;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function handleRefresh()
    {
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function resetFilter()
    {
        $this->search = "";
        $this->resetPage();
    }

    public function render()
    {
        $groups = Group::with('employees', 'supervisor')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        });

        if($this->authUser->hasRole('Supervisor')) {
            $groups->where('supervisor_id', $this->authUser->id);
        }

        $groups = $groups->paginate($this->perPage);
        return view('livewire.group.group-list', compact('groups'));
    }
}
