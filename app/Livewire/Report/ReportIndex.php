<?php

namespace App\Livewire\Report;

use App\Models\Activity;
use App\Models\Area;
use App\Models\User;
use App\Models\Group;
use App\Models\Scope;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Position;

class ReportIndex extends Component
{
    use LivewireAlert;

    public $search = '';
    public $perPage = 30;


    public $filterArea = [];
    public $filterScope = [];
    public $filterPosition = [];
    public $filterDate = '';
    public $filterSupervisor = [];

    public $areas = [];
    public $positions = [];
    public $scopes = [];
    public $supervisors = [];
    public $activities = [];

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->areas = Area::all();
        $this->positions = Position::all();
        $this->scopes = Scope::all();
        $this->supervisors = User::role('Supervisor')->get();
    }

    public function resetFilter()
    {
        $this->search = "";
        $this->filterArea = [];
        $this->filterScope = [];
        $this->filterPosition = [];
        $this->filterDate = "";
        $this->filterSupervisor = [];

        $this->activities = [];
    }

    #[On('filterAreaSelected')]
    public function filterAreaSelected($value)
    {
        $this->filterArea = $value;
    }

    #[On('filterScopeSelected')]
    public function filterScopeSelected($value)
    {
        $this->filterScope = $value;
    }

    #[On('filterPositionSelected')]
    public function filterPositionSelected($value)
    {
        $this->filterPosition = $value;
    }

    #[On('filterSupervisorSelected')]
    public function filterSupervisorSelected($value)
    {
        $this->filterSupervisor = $value;
    }

    public function filter()
    {
        $this->activities = Activity::with('area', 'scope', 'issues.categoryDependency', 'supervisor', 'position', 'status')
        ->with(['historyProgress' => function ($query) {
            $query->orderBy('date', 'asc');
        }])
        ->when($this->filterScope, function ($query) {
            return $query->whereIn('scope_id', $this->filterScope);
        })
        ->when($this->filterArea, function ($query) {
            return $query->whereIn('area_id', $this->filterArea);
        })
        ->when($this->filterPosition, function ($query) {
            return $query->where('position_id', $this->filterPosition);
        })
        ->when($this->filterDate, function ($query) {
            return $query->whereHas('issues', function ($query) {
                $query->where('date', $this->filterDate);
            })->orWhereHas('historyProgress', function ($query) {
                $query->where('date', $this->filterDate);
            });
        })
        ->when($this->filterSupervisor, function ($query) {
            return $query->where('supervisor_id', $this->filterSupervisor);
        })
        ->orderBy('id', 'asc')
        ->get()->toArray();

        if(empty($this->activities)) {
            $this->alert('warning', 'Data Not Found');
        }

        $this->dispatch('refreshActivities', $this->activities);
    }

    public function render()
    {
        return view('livewire.report.report-index')->layout('layouts.app', ['title' => 'Report Activity']);
    }
}
