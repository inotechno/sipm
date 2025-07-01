<?php

namespace App\Livewire\Activity;

use App\Jobs\SendWhatsappJob;
use App\Livewire\BaseComponent;
use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\ActivityProgress;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityUpdateProgress extends BaseComponent
{
    use LivewireAlert;

    public $activity_id;
    public $scopes = [];
    public $progress;

    public $quantity, $date, $lastProgress, $totalQuantity, $totalProgress;

    #[On('show-modal-progress')]
    public function updateProgress($activity_id)
    {
        $this->activity_id = $activity_id;
        $activity = Activity::with('historyProgress')->find($activity_id);
        $this->progress = $activity->historyProgress->toArray();
        $this->totalQuantity = $activity->total_quantity ?? 0;
        $this->lastProgress = $activity->progress;

        $this->dispatch('showFormProgress');
    }

    public function submitProgress()
    {
        $this->validate([
            'date' => 'required',
            'activity_id' => 'required',
            'quantity' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $percentage = ($this->quantity / $this->totalQuantity) * 100;

            ActivityProgress::create([
                'activity_id' => $this->activity_id,
                'date' => $this->date,
                'user_id' => $this->authUser->id,
                'quantity' => $this->quantity,
                'percentage' => $percentage
            ]);

            $activity = ActivityProgress::where('activity_id', $this->activity_id)->get();
            $totalQuantity = $activity->sum('quantity') ?? 0;

            // convert to percentage
            $totalProgress = ($totalQuantity / $this->totalQuantity) * 100;
            // dd($totalQuantity, $this->totalQuantity, $totalProgress);
            
            Activity::where('id', $this->activity_id)->update([
                'progress' => $totalProgress
            ]);

            DB::commit();

            // Save/update progress here
            $this->alert('success', 'Progress updated to database successfully');
            $this->dispatch('hideFormProgress');
            return redirect()->route('activity');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', $e->getMessage());
            $this->dispatch('hideFormProgress');
            return redirect()->route('activity');
        }

    }

    public function render()
    {
        return view('livewire.activity.activity-update-progress');
    }
}
