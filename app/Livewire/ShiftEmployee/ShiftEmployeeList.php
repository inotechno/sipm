<?php

namespace App\Livewire\ShiftEmployee;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use App\Models\Shift;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ShiftEmployeeList extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]

    public $search = '';

    public $filterGroup = '';
    public $filterPosition = '';
    public $filterStartDate = '';
    public $filterEndDate = '';
    public $filterEmployee = '';

    public $groups = [];
    public $positions = [];
    public $employees = [];

    public $dateRange = [];
    public $schedules;
    public $shifts = [];
    public $employeeID, $dateSchedule;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterGroup' => ['except' => ''],
        'filterPosition' => ['except' => ''],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
        'filterEmployee' => ['except' => ''],
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->filterGroup = '';
        $this->filterPosition = '';
        $this->filterEmployee = '';

        $this->resetPage();
        $this->loadSchedules();
    }

    public function handleRefresh()
    {
        $this->loadSchedules(); // Load data saat komponen pertama kali dimuat
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        $this->groups = \App\Models\Group::all();
        $this->positions = \App\Models\Position::all();
        $this->employees = Employee::all();

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $this->filterStartDate = Carbon::createFromDate($year, $month, 1)->format('Y-m-d');
        $this->filterEndDate = Carbon::parse($this->filterStartDate)->endOfMonth()->format('Y-m-d');

        $this->loadSchedules(); // Load data saat komponen pertama kali dimuat

    }

    public function filter()
    {
        $this->resetPage();
        $this->loadSchedules(); // Load data saat komponen pertama kali dimuat

        $this->dispatch('$refresh');
    }

    public function loadSchedules()
    {
        // Buat range tanggal
        $startDate = Carbon::parse($this->filterStartDate);
        $endDate = Carbon::parse($this->filterEndDate);
        $this->dateRange = collect();

        while ($startDate <= $endDate) {
            $this->dateRange->push($startDate->format('Y-m-d'));
            $startDate->addDay();
        }

        // Ambil data karyawan dengan jadwal dan shift dalam range tanggal
        $this->schedules = Employee::whereHas('group', function ($query) {
            $query->where('supervisor_id', $this->authUser->id);
        })->with([
                    'schedules' => function ($query) {
                        $query->whereBetween('date', [$this->filterStartDate, $this->filterEndDate])
                            ->with('shift');
                    }
                ])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterGroup, function ($query) {
                $query->where('group_id', $this->filterGroup);
            })
            ->when($this->filterPosition, function ($query) {
                $query->where('position_id', $this->filterPosition);
            })
            ->when($this->filterEmployee, function ($query) {
                $query->where('id', $this->filterEmployee);
            })
            ->get();

        // Proses jadwal menjadi format yang lebih mudah digunakan
        $this->schedules->transform(function ($employee) {
            $schedulesByDate = collect($employee->schedules)
                ->mapWithKeys(function ($schedule) {
                    return [$schedule->date => $schedule->shift->name ?? '-'];
                });

            $employee->schedules_by_date = $this->dateRange->mapWithKeys(function ($date) use ($schedulesByDate) {
                return [$date => $schedulesByDate->get($date, '-')];
            });

            return $employee;
        });
    }



    public function render()
    {
        return view('livewire.shift-employee.shift-employee-list')->layout('layouts.app', ['title' => 'Shift Employee']);
    }
}
