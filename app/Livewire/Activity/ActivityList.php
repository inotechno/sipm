<?php

namespace App\Livewire\Activity;

use App\Jobs\SendWhatsappJob;
use App\Livewire\BaseComponent;
use App\Models\StatusActivity;
use App\Models\User;
use App\Models\Area;
use App\Models\Scope;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Activity;
use App\Models\Position;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;

class ActivityList extends BaseComponent
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(except: '')]

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

    public $activity_id = '';

    public $statuses = [];
    public $status_id = '';
    public $progress = 0;

    public $actual_date;

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

    public function updatingSearch()
    {
        $this->resetPage();
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

    public function handleRefresh()
    {
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function resetFilter()
    {
        $this->search = "";
        $this->filterArea = [];
        $this->filterScope = [];
        $this->filterPosition = [];
        $this->filterDate = "";
        $this->filterSupervisor = [];

        $this->resetPage();
    }

    public function filter()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    #[On('show-modal-validation')]
    public function validationActivity($activity_id)
    {
        $this->activity_id = $activity_id;
        $this->status_id = Activity::find($activity_id)->status_id;
        $this->statuses = StatusActivity::whereNot('id', 4)->get();
        $this->dispatch('showFormValidation');
    }

    #[On('show-modal-actual-date')]
    public function updateActualDate($activity_id)
    {
        $this->activity_id = $activity_id;
        $this->dispatch('showFormActualDate');
    }

    public function submitValidation()
    {
        $this->validate([
            'activity_id' => 'required',
            'status_id' => 'required',
        ], [
            'status_id.required' => 'Status is required',
            'activity_id.required' => 'Activity is required',
        ]);

        try {
            $activity = Activity::find($this->activity_id);
            $activity->status_id = $this->status_id;
            $activity->save();

            // $supervisors = User::where('id', 1)->get();
            $supervisors = User::role('Supervisor')->get();
            foreach ($supervisors as $supervisor) {
                $phone = $supervisor->phone;
                $message = "🔔 *Activity Update!*\n"
                    . "The activity *'{$activity->scope->name}'* in *'{$activity->area->name}'* under the position *'{$activity->position->name}'*, supervised by *'{$activity->supervisor->name}'*, has been updated to *'{$activity->status->name}'*.\n"
                    . "🚀 *Check the details now:* https://kms.tpm-facility.com/activities";

                if ($phone != null) {
                    SendWhatsappJob::dispatch($phone, $message);
                }
            }

            $this->alert('success', 'Status updated successfully');
            $this->dispatch('hideFormValidation');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            $this->alert('error', 'Status could not be updated');
        }
    }

    public function submitActualDate()
    {
        $this->validate([
            'activity_id' => 'required',
            'actual_date' => 'required'
        ]);

        try {
            $activity = Activity::find($this->activity_id);
            $activity->actual_date = $this->actual_date;
            $activity->save();

            $this->alert('success', 'Actual Date updated successfully');
            $this->dispatch('hideFormValidation');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            $this->alert('error', 'Status could not be updated');
        }
    }

    public function render()
    {
        $activities = Activity::with('area', 'scope', 'issues', 'supervisor', 'position', 'status');

        if ($this->authUser->hasRole('Supervisor')) {
            $activities->where('supervisor_id', $this->authUser->id);
        }

        $activities = $activities->when($this->search, function ($query) {
            return $query->whereHas('scope', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->filterArea, function ($query) {
                return $query->whereIn('area_id', $this->filterArea);
            })
            ->when($this->filterScope, function ($query) {
                return $query->whereIn('scope_id', $this->filterScope);
            })
            ->when($this->filterPosition, function ($query) {
                return $query->whereIn('position_id', $this->filterPosition);
            })
            ->when($this->filterDate, function ($query) {
                return $query->where('date', $this->filterDate);
            })
            ->when($this->filterSupervisor, function ($query) {
                return $query->whereIn('supervisor_id', $this->filterSupervisor);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.activity.activity-list', compact('activities'));
    }
}
