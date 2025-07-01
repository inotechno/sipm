<?php

namespace App\Livewire\Dashboard\DashboardActivity;

use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\ActivityProgress as ActivityProgressModel;

class ActivityProgress extends Component
{
    public $filter = 'today'; // Default filter: Hari ini
    public $chartData = [];
    public $chartCategories = [];

    public function mount()
    {
        $this->updateChartData();
    }

    public function filterByToday()
    {
        $this->filter = 'today';
        $this->updateChartData();
        $this->dispatch('updateProgressChart', categories: $this->chartCategories, data: $this->chartData);
    }

    public function filterByWeek()
    {
        $this->filter = 'week';
        $this->updateChartData();
        $this->dispatch('updateProgressChart', categories: $this->chartCategories, data: $this->chartData);
    }

    public function filterByMonth()
    {
        $this->filter = 'month';
        $this->updateChartData();
        // dd($this->chartData);
        $this->dispatch('updateProgressChart', categories: $this->chartCategories, data: $this->chartData);
    }

    public function updateChartData()
    {
        $now = Carbon::now();

        switch ($this->filter) {
            case 'today':
                $progressData = ActivityProgressModel::join('activities', 'activities.id', '=', 'activity_progress.activity_id')
                    ->join('scopes', 'scopes.id', '=', 'activities.scope_id')
                    ->whereDate('activity_progress.date', $now->format('Y-m-d'))
                    ->selectRaw('HOUR(activity_progress.date) as hour, activities.scope_id, scopes.name as scope_name, SUM(activity_progress.quantity) as total_progress')
                    ->groupBy('hour', 'activities.scope_id', 'scopes.name')
                    ->orderBy('hour')
                    ->get();

                $this->chartCategories = $progressData->pluck('hour')->unique()->map(fn($hour) => Carbon::createFromTime($hour)->format('H:i'))->values();
                break;

            case 'week':
                $progressData = ActivityProgressModel::join('activities', 'activities.id', '=', 'activity_progress.activity_id')
                    ->join('scopes', 'scopes.id', '=', 'activities.scope_id')
                    ->whereBetween('activity_progress.date', [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])
                    ->selectRaw('DATE(activity_progress.date) as date, activities.scope_id, scopes.name as scope_name, SUM(activity_progress.quantity) as total_progress')
                    ->groupBy('date', 'activities.scope_id', 'scopes.name')
                    ->orderBy('date')
                    ->get();

                $this->chartCategories = $progressData->pluck('date')->unique()->map(fn($date) => Carbon::parse($date)->format('D, d M'))->values();
                break;

            case 'month':
                $progressData = ActivityProgressModel::join('activities', 'activities.id', '=', 'activity_progress.activity_id')
                    ->join('scopes', 'scopes.id', '=', 'activities.scope_id')
                    ->whereBetween('activity_progress.date', [$now->startOfMonth()->format('Y-m-d'), $now->endOfMonth()->format('Y-m-d')])
                    ->selectRaw('DATE(activity_progress.date) as date, activities.scope_id, scopes.name as scope_name, SUM(activity_progress.quantity) as total_progress')
                    ->groupBy('date', 'activities.scope_id', 'scopes.name')
                    ->orderBy('date')
                    ->get();

                $this->chartCategories = $progressData->pluck('date')->unique()->map(fn($date) => Carbon::parse($date)->format('d M'))->values();
                break;
        }

        // Ambil daftar scope unik
        $scopes = $progressData->pluck('scope_id')->unique();

        // Buat format data untuk setiap scope
        $this->chartData = array_values($scopes->map(function ($scopeId) use ($progressData) {
            $scopeName = $progressData->where('scope_id', $scopeId)->first()->scope_name ?? "Unknown Scope";

            return [
                'name' => $scopeName,
                'data' => $this->chartCategories->map(
                    fn($category) =>
                    (int) ($progressData->where('scope_id', $scopeId)
                        ->when($this->filter === 'today', fn($q) => $q->where('hour', $category))  // ✅ Pakai hour untuk today
                        ->when(in_array($this->filter, ['week', 'month']), fn($q) => $q->where('date', Carbon::parse($category)->format('Y-m-d'))) // ✅ Pakai date untuk week & month
                        ->sum('total_progress') ?? 0)
                )->toArray()
            ];
        })->toArray());

    }


    public function render()
    {
        return view('livewire.dashboard.dashboard-activity.activity-progress');
    }
}
