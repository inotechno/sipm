<?php

namespace App\Livewire\Activity;

use App\Models\Activity;
use App\Models\Group;
use App\Models\Position;
use App\Models\Scope;
use App\Models\User;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityForm extends Component
{
    use LivewireAlert;
    public $mode = 'create';
    public $scope_id, $group_id, $position_id, $total_estimate, $forecast_date, $plan_date, $actual_date, $supervisor_id, $description;
    public $selectedScopes = [];

    public $positions, $scopes, $groups, $supervisors;

    public function mount()
    {
        $this->groups = Group::all();
        $this->positions = Position::all();
        $this->scopes = Scope::all();
        $this->supervisors = User::role('Supervisor')->get();
    }

    #[On('change-input-form')]
    public function changeInputForm($param, $value)
    {
        $this->$param = $value;
    }

    public function submit()
    {
        $this->validate([
            'scope_id' => 'required',
            'group_id' => 'required',
            'position_id' => 'required',
            'total_estimate' => 'required|numeric',
            'forecast_date' => 'required|date',
            'plan_date' => 'required|date',
            'supervisor_id' => 'required',
            'description' => 'nullable',
        ]);

        try {
            $activity = Activity::create([
                'scope_id' => $this->scope_id,
                'group_id' => $this->group_id,
                'position_id' => $this->position_id,
                'total_estimate' => $this->total_estimate,
                'forecast_date' => $this->forecast_date,
                'plan_date' => $this->plan_date,
                'actual_date' => $this->actual_date,
                'supervisor_id' => $this->supervisor_id,
                'description' => $this->description,
                'status_id' => 3
            ]);

            $this->alert('success', 'Activity saved successfully', ['position' => 'top-center']);
            $this->resetForm();
            $this->dispatch('refreshIndex');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage(), ['position' => 'top-center']);
        }
    }

    public function resetForm()
    {
        $this->scope_id = null;
        $this->group_id = null;
        $this->position_id = null;
        $this->selectedScopes = [];
        $this->total_estimate = null;
        $this->forecast_date = null;
        $this->plan_date = null;
        $this->actual_date = null;
        $this->supervisor_id = null;
        $this->description = null;
    }

    public function render()
    {
        return view('livewire.activity.activity-form');
    }
}
