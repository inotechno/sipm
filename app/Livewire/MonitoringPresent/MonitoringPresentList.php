<?php

namespace App\Livewire\MonitoringPresent;

use App\Livewire\BaseComponent;
use App\Models\Group;
use App\Models\MonitoringPresent;
use App\Models\Shift;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class MonitoringPresentList extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filterStartDate;
    public $filterEndDate;
    public $filterShift;
    public $filterGroup;
    public $filterType;
    public $perPage = 20;

    public $groups, $shifts;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    public function handleRefresh()
    {
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        if ($this->authUser->hasRole('Supervisor')) {
            $this->groups = Group::where('supervisor_id', $this->authUser->id)->get();
        } else {
            $this->groups = Group::all();
        }

        $this->shifts = Shift::all();
    }
    public function resetFilter()
    {
        $this->filterStartDate = null;
        $this->filterEndDate = null;
        $this->filterShift = null;
        $this->filterGroup = null;
        $this->filterType = null;
    }

    public function filter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $monitoring_presents = MonitoringPresent::with('shift', 'user', 'group', 'details');

        if ($this->authUser->hasRole('Supervisor')) {
            $monitoring_presents->where('user_id', $this->authUser->id)->where('role', 'supervisor');
        } elseif ($this->authUser->hasRole('HSE')) { 
            $monitoring_presents->where('role', 'hse');
        }

        $monitoring_presents->when($this->filterStartDate, function ($query) {
            return $query->whereDate('datetime', '>=', $this->filterStartDate);
        })->when($this->filterEndDate, function ($query) {
            return $query->whereDate('datetime', '<=', $this->filterEndDate);
        })->when($this->filterShift, function ($query) {
            return $query->where('shift_id', $this->filterShift);
        })->when($this->filterGroup, function ($query) {
            return $query->where('group_id', $this->filterGroup);
        })->when($this->filterType, function ($query) {
            return $query->where('type', $this->filterType);
        })->orderBy('id', 'desc');

        $monitoring_presents = $monitoring_presents->paginate($this->perPage);

        return view('livewire.monitoring-present.monitoring-present-list', compact('monitoring_presents'))->layout('layouts.app', ['title' => 'Monitoring Present']);
    }
}
