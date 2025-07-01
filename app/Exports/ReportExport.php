<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $activities;
    protected $currentRow = 1; // Track current row for mapping

    public function __construct($activities)
    {
        $this->activities = $activities;
    }

    public function collection()
    {
        return collect($this->activities);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Scope',
            'Area',
            'Position',
            'Estimate Time',
            'Quantity',
            'Forecast Date',
            'Plan Date',
            'Actual Date',
            'Progress',
            'Supervisor',
            'Dependencies',
            'Status',
        ];
    }

    public function map($activity): array
    {
        // Ambil semua scope dari relasi details.scope dan gabungkan menjadi string
        $historyProgress = collect($activity['history_progress'] ?? [])
            ->map(function ($progress) {
                return ($progress['date'] ?? '') . ': ' . ($progress['quantity'] ? $progress['quantity']: '-');
            })->join(', ');

        // Ambil semua dependency dan gabungkan menjadi string
        $dependencies = collect($activity['issues'] ?? [])
            ->map(function ($issue) {
                return ($issue['category_dependency']['name'] ?? '') . ($issue['percentage_dependency']).'% : ' . ($issue['description'] ?? '');
            })
            ->join(', '); // Gabungkan menjadi string dengan koma sebagai pemisah


        return [
            $activity['id'],
            $activity['scope']['name'] ?? '',
            $activity['area']['name'] ?? '',
            $activity['position']['name'] ?? '',
            $activity['total_estimate'] .' Day',
            $activity['total_quantity'] ?? 0,
            $activity['forecast_date'],
            $activity['plan_date'],
            $activity['actual_date'] ?? '-',
            $historyProgress. ', '. $activity['progress'].'%',
            $activity['supervisor']['name'] ?? '',
            $dependencies,
            $activity['status']['name'] ?? '',
        ];
    }
}
