<?php

namespace App\Livewire\User;

use App\Livewire\BaseComponent;
use App\Models\User;use Livewire\Attributes\Url;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[URL(except: '')]

    public $search = '';
    public $perPage = 21;

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
        $users = User::with('roles', 'permissions')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })->paginate($this->perPage);

        return view('livewire.user.user-list', compact('users'));
    }
}
