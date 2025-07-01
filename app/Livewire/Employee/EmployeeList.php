<?php

namespace App\Livewire\Employee;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeList extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 12;

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
        $employees = Employee::with('group', 'position')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%');
        });

        if($this->authUser->hasRole('Supervisor')) {
            $employees->whereHas('group', function ($query) {
                $query->where('supervisor_id', $this->authUser->id);
            });
        }

        $employees = $employees->paginate($this->perPage);
        return view('livewire.employee.employee-list', compact('employees'));
    }
}
