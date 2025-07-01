<?php

namespace App\Livewire\MonitoringPresent;

use App\Jobs\AbsentNotification;
use App\Livewire\BaseComponent;
use App\Models\Employee;
use App\Models\MonitoringPresent;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class MonitoringPresentForm extends BaseComponent
{
    use LivewireAlert;

    public $employees, $shifts, $shiftForms;
    public $user_id, $shift_id, $datetime, $type, $group_id, $role, $shift_date;
    public $shift_1, $shift_2;

    public $move_supervisors = [];
    public $is_presents = [];
    public $notes = [];
    public $reasons = [];

    public $search = '';
    public $groups;
    public $select_all = false;
    public $supervisors;

    protected $queryString = ['search' => ['except' => '']];

    public function updatedSearch()
    {
        if ($this->authUser->hasRole('Supervisor')) {
            $this->employees = Employee::with('group')->whereHas('group', function ($query) {
                $query->where('supervisor_id', $this->authUser->id);
            })
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        } else {
            $this->employees = Employee::with('group')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        }
    }

    public function updatedShiftDate()
    {
        $this->shiftForms = Shift::where('day_of_week', strtolower(Carbon::parse($this->shift_date)->format('l')))->get();
    }

    public function selectAll()
    {
        if (!$this->select_all) {
            foreach ($this->employees as $employee) {
                $this->is_presents[$employee->id] = true;
            }

            $this->select_all = true;
        } else {
            foreach ($this->employees as $employee) {
                $this->is_presents[$employee->id] = false;
            }

            $this->select_all = false;
        }

        // dd($this->select_all); 
    }

    public function resetForm()
    {
        $this->is_presents = [];
        $this->reasons = [];
        $this->notes = [];
        $this->move_supervisors = [];
        $this->user_id = '';
        $this->shift_date = '';
        $this->shift_id = '';
        $this->datetime = '';
        $this->type = '';
        $this->group_id = '';
    }

    public function submitMonitoringPresent()
    {
        $this->validate([
            'user_id' => 'required',
            'shift_id' => 'required',
            'type' => 'required',
            'group_id' => 'required',
            'is_presents.*' => 'required',
            'role' => 'required',
            'notes.*' => 'nullable',
            'reasons.*' => 'nullable',
            'move_supervisors.*' => 'nullable',
        ]);

        // dd($this->move_supervisors, $this->is_presents);
        try {
            $this->datetime = Carbon::now();

            $existMonitoring = MonitoringPresent::where('shift_id', $this->shift_id)
                ->where('group_id', $this->group_id)
                ->where('role', $this->role)
                ->where('type', $this->type)
                ->where('user_id', $this->authUser->id)
                ->where('shift_date', $this->shift_date)
                ->exists();

            if ($existMonitoring) {
                $this->alert('error', 'Monitoring untuk shift dan tipe ini sudah ada');
                return;
            }

            DB::transaction(function () {
                $monitoring = MonitoringPresent::create([
                    'user_id' => $this->user_id,
                    'shift_id' => $this->shift_id,
                    'datetime' => $this->datetime,
                    'group_id' => $this->group_id,
                    'type' => $this->type,
                    'role' => $this->role,
                    'shift_date' => $this->shift_date
                ]);

                foreach ($this->is_presents as $id => $is_present) {
                    $monitoring->details()->create([
                        'employee_id' => $id,
                        'is_present' => $is_present,
                        'note' => $this->notes[$id],
                        'reason' => $this->reasons[$id],
                        'move_supervisor_id' => intval($this->move_supervisors[$id])
                    ]);

                    if (!$is_present) {
                        $data = [
                            'employee_id' => $id,
                            'date' => $this->datetime,
                            'shift' => $monitoring->shift->name
                        ];

                        // AbsentNotification::dispatch($data);
                    }
                }

                DB::commit();
            });

            $this->alert('success', 'Data monitoring berhasil disimpan');
            $this->dispatch('refreshIndex');
            $this->dispatch('hideModalAddMonitoring');
            $this->resetForm();
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function updatedGroupId()
    {
        if ($this->group_id != "") {
            $employees = Employee::where('group_id', $this->group_id)->get();
        } else {
            $employees = Employee::with('group')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        }

        $this->is_presents = [];
        $this->notes = [];
        $this->reasons = [];
        $this->move_supervisors = [];

        $this->select_all = false;
        foreach ($employees as $employee) {
            $this->is_presents[$employee->id] = false; // Inisialisasi semua dengan false
            $this->notes[$employee->id] = '';
            $this->reasons[$employee->id] = '';
            $this->move_supervisors[$employee->id] = '';
        }

        $this->employees = $employees;
    }

    public function mount($groups)
    {
        // $hour = 7;
        $hour = Carbon::now()->hour;

        if ($this->authUser->hasRole('Supervisor')) {
            $this->employees = Employee::with('group')->whereHas('group', function ($query) {
                $query->where('supervisor_id', $this->authUser->id);
            })->get();

            $this->role = 'supervisor';
        } else {
            $this->employees = Employee::with('group')->get();
            $this->role = 'hse';
        }

        foreach ($this->employees as $employee) {
            $this->is_presents[$employee->id] = false; // Inisialisasi semua dengan false
            $this->notes[$employee->id] = '';
            $this->reasons[$employee->id] = '';
            $this->move_supervisors[$employee->id] = '';
        }
        
        $this->shiftForms = Shift::where('day_of_week', strtolower(Carbon::now()->format('l')))->get();
        $this->shift_date = Carbon::now()->format('Y-m-d');

        if($hour >= 0 && $hour < 7){
            $this->shift_date = Carbon::now()->subDay()->format('Y-m-d');
            $this->shiftForms = Shift::where('day_of_week', strtolower(Carbon::now()->subDay()->format('l')))->get();  
        }

        $this->user_id = $this->authUser->id;
        $this->groups = $groups;
        $this->supervisors = User::role('Supervisor')->get();
        // dd($this->shiftForms);
        $this->shift_1 = $this->shiftForms->first()->id;
        $this->shift_2 = $this->shiftForms->last()->id;
    }

    public function render()
    {
        return view('livewire.monitoring-present.monitoring-present-form');
    }
}
