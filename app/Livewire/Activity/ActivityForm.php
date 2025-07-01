<?php

namespace App\Livewire\Activity;

use App\Models\Activity;
use App\Models\Area;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Position;
use App\Models\Scope;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityForm extends Component
{
    use LivewireAlert;
    public $mode = 'create';
    public $activity_id, $scope_id, $area_id, $position_id, $total_quantity, $total_estimate, $forecast_date, $plan_date, $actual_date, $supervisor_id, $description;
    public $selectedEmployees = [];
    public $positions, $scopes, $areas, $groups, $supervisors;

    public function mount($activity_id = null)
    {
        $activity = Activity::with('employees.group')->find($activity_id);

        if ($activity) {
            $this->mode = 'edit';
            $this->scope_id = $activity->scope_id;
            $this->area_id = $activity->area_id;
            $this->position_id = $activity->position_id;
            $this->total_estimate = $activity->total_estimate;
            $this->forecast_date = $activity->forecast_date;
            $this->plan_date = $activity->plan_date;
            $this->total_quantity = $activity->total_quantity;
            $this->actual_date = $activity->actual_date;
            $this->supervisor_id = $activity->supervisor_id;
            $this->description = $activity->description;

            foreach ($activity->employees as $employee) {
                $this->dispatch('setSelectedEmployees', employee: $employee);
            }
        }

        $this->areas = Area::all();
        $this->positions = Position::all();
        $this->scopes = Scope::all();
        $this->supervisors = User::role('Supervisor')->get();
        $this->groups = Group::all();

        $this->activity_id = $activity_id;
    }

    public function updatedSupervisorId()
    {
        $this->resetSelectedEmployees();

        $group = Group::with('employees')->where('supervisor_id', $this->supervisor_id)->first();
        if ($group) {
            foreach ($group->employees as $employee) {
                $this->dispatch('setSelectedEmployees', employee: $employee);
            }

            $this->dispatch('setFilterGroup', groupId: $group->id);
        } else {
            $this->alert('warning', 'No employees found for the selected supervisor.');
        }
    }

    #[On('setSelectedEmployees')]
    public function setSelectedEmployees($employee)
    {
        $employeeId = $employee['id'];

        if (isset($this->selectedEmployees[$employeeId])) {
            unset($this->selectedEmployees[$employeeId]);
        } else {
            $this->selectedEmployees[$employeeId] = $employee;
        }

        $this->dispatch('updateSelectedEmployees', selectedEmployees: array_keys($this->selectedEmployees));
    }

    #[On('resetSelectedEmployees')]
    public function resetSelectedEmployees()
    {
        $this->selectedEmployees = [];
        $this->dispatch('updateSelectedEmployees', selectedEmployees: array_keys($this->selectedEmployees));
    }

    #[On('allSelectedEmployees')]
    public function allSelectedEmployees($employees)
    {
        $this->selectedEmployees = $employees;
    }

    public function submit()
    {
        $this->validate([
            'scope_id' => 'required',
            'area_id' => 'required',
            'position_id' => 'required',
            'total_estimate' => 'required|numeric',
            'forecast_date' => 'required|date',
            'plan_date' => 'required|date',
            'total_quantity' => 'nullable|numeric',
            'supervisor_id' => 'required',
            'description' => 'nullable',
            'selectedEmployees' => 'required|array|min:1'
        ]);

        try {
            // Ambil hanya array utama tanpa indeks numerik
            $flattenedEmployees = array_values($this->selectedEmployees);

            $employeeIds = [];
            foreach ($flattenedEmployees as $employee) {
                $employeeIds[] = $employee['id'];
            }

            // dd($employeeIds);
            DB::transaction(function () use ($employeeIds) {

                if ($this->mode == 'edit') {
                    $activity = Activity::find($this->activity_id);
                    $activity->update([
                        'scope_id' => $this->scope_id,
                        'area_id' => $this->area_id,
                        'position_id' => $this->position_id,
                        'total_estimate' => $this->total_estimate,
                        'forecast_date' => $this->forecast_date,
                        'plan_date' => $this->plan_date,
                        'actual_date' => $this->actual_date,
                        'total_quantity' => $this->total_quantity,
                        'supervisor_id' => $this->supervisor_id,
                        'description' => $this->description,
                        'status_id' => 3
                    ]);

                    $activity->employees()->sync($employeeIds);

                    $this->alert('success', 'Activity updated successfully', ['position' => 'top-center']);
                    $this->resetForm();
                    $this->dispatch('refreshIndex');
                    return redirect()->route('activity');
                }


                $activity = Activity::create([
                    'scope_id' => $this->scope_id,
                    'area_id' => $this->area_id,
                    'position_id' => $this->position_id,
                    'total_estimate' => $this->total_estimate,
                    'forecast_date' => $this->forecast_date,
                    'plan_date' => $this->plan_date,
                    'actual_date' => $this->actual_date,
                    'total_quantity' => $this->total_quantity,
                    'supervisor_id' => $this->supervisor_id,
                    'description' => $this->description,
                    'status_id' => 3
                ]);

                $activity->employees()->sync($employeeIds);

                DB::commit();
            });

            $this->alert('success', 'Activity saved successfully', ['position' => 'top-center']);
            $this->resetForm();
            $this->dispatch('refreshIndex');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', $e->getMessage(), ['position' => 'top-center']);
        }
    }

    public function changeNewPlan()
    {
        $this->validate([
            'scope_id' => 'required',
            'area_id' => 'required',
            'position_id' => 'required',
            'total_estimate' => 'required|numeric',
            'forecast_date' => 'required|date',
            'plan_date' => 'required|date',
            'total_quantity' => 'nullable|numeric',
            'supervisor_id' => 'required',
            'description' => 'nullable',
            'selectedEmployees' => 'required|array|min:1'
        ]);

        try {
            // Ambil hanya array utama tanpa indeks numerik
            $flattenedEmployees = array_values($this->selectedEmployees);

            $employeeIds = [];
            foreach ($flattenedEmployees as $employee) {
                $employeeIds[] = $employee['id'];
            }

            DB::transaction(function () use ($employeeIds) {
                // dd($employeeIds);
                $activity = Activity::create([
                    'scope_id' => $this->scope_id,
                    'area_id' => $this->area_id,
                    'position_id' => $this->position_id,
                    'total_estimate' => $this->total_estimate,
                    'forecast_date' => $this->forecast_date,
                    'plan_date' => $this->plan_date,
                    'actual_date' => $this->actual_date,
                    'total_quantity' => $this->total_quantity,
                    'supervisor_id' => $this->supervisor_id,
                    'description' => $this->description,
                    'status_id' => 3
                ]);

                $activity->employees()->sync($employeeIds);

                Activity::find($this->activity_id)->update([
                    'status_id' => 4,
                    'change_to_activity_id' => $activity->id
                ]);
            });

            $this->alert('success', 'Activity saved successfully', ['position' => 'top-center']);
            $this->resetForm();
            $this->dispatch('refreshIndex');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', $e->getMessage(), ['position' => 'top-center']);
        }
    }

    public function resetForm()
    {
        $this->scope_id = null;
        $this->area_id = null;
        $this->position_id = null;
        $this->total_estimate = null;
        $this->forecast_date = null;
        $this->plan_date = null;
        $this->total_quantity = null;
        $this->actual_date = null;
        $this->supervisor_id = null;
        $this->description = null;

        $this->selectedEmployees = [];
        $this->dispatch('updateSelectedEmployees', selectedEmployees: array_keys($this->selectedEmployees));
    }

    public function render()
    {
        return view('livewire.activity.activity-form')->layout('layouts.app', ['title' => 'Activity']);
    }
}
