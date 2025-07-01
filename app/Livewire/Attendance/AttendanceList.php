<?php

namespace App\Livewire\Attendance;

use App\Exports\AttendanceExport;
use App\Livewire\BaseComponent;
use App\Models\Attendance;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceList extends BaseComponent
{
    use LivewireAlert, WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]

    public $search = '';
    public $perPage = 25;

    public $filterGroup = [];
    public $filterPosition = [];
    public $filterStartDate = '';
    public $filterEndDate = '';
    public $filterEmployee = [];

    public $groups = [];
    public $positions = [];
    public $employees = [];
    public $file = null;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
        'refreshList' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 30],
        'filterGroup' => ['except' => []],
        'filterPosition' => ['except' => []],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
        'filterEmployee' => ['except' => []],
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->filterGroup = [];
        $this->filterPosition = [];
        $this->filterStartDate = '';
        $this->filterEndDate = '';
        $this->filterEmployee = [];

        $this->dispatch('reset-select2');
    }

    public function handleRefresh()
    {
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        $this->groups = \App\Models\Group::all();
        $this->positions = \App\Models\Position::all();
        $this->employees = \App\Models\Employee::all();
    }

    public function filter()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    #[On('filterEmployeeSelected')]
    public function filterEmployeeSelected($value)
    {
        $this->filterEmployee = $value;
        $this->filter();
    }

    #[On('filterGroupSelected')]
    public function filterGroupSelected($value)
    {
        $this->filterGroup = $value;
        $this->filter();
    }

    #[On('filterPositionSelected')]
    public function filterPositionSelected($value)
    {
        $this->filterPosition = $value;
        $this->filter();
    }

    public function downloadTemplate()
    {
       return Excel::download(new AttendanceExport, 'Attendance Import Template.xlsx');
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        try {
            Excel::import(new \App\Imports\AttendanceImport, $this->file);
            $this->alert('success', 'Data Imported Successfully');
            $this->reset('file');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        $attendances = Attendance::with('employee.group', 'employee.position')
            ->when($this->search, function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            });

        if ($this->authUser->hasRole('Supervisor')) {
            $attendances->whereHas('employee.group', function ($query) {
                $query->where('supervisor_id', $this->authUser->id);
            });
        }

        $attendances = $attendances->when($this->filterEmployee, function ($query) {
            $query->whereIn('employee_id', $this->filterEmployee);
        })->when($this->filterGroup, function ($query) {
            $query->whereHas('employee', function ($query) {
                $query->whereIn('group_id', $this->filterGroup);
            });
        })->when($this->filterPosition, function ($query) {
            $query->whereHas('employee', function ($query) {
                $query->whereIn('position_id', $this->filterPosition);
            });
        })->when($this->filterStartDate, function ($query) {
            $query->whereDate('timestamp', '>=', $this->filterStartDate);
        })->when($this->filterEndDate, function ($query) {
            $query->whereDate('timestamp', '<=', $this->filterEndDate);
        })->onlyActiveEmployees()->orderBy('timestamp', 'desc')->paginate($this->perPage);

        return view('livewire.attendance.attendance-list', compact('attendances'));
    }
}
