<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportActivityProgressExport implements FromCollection, WithHeadings, WithMapping
{
    protected $progresses;
    protected $currentRow = 1; // Track current row for mapping

    public function __construct($progresses)
    {
        $this->progresses = $progresses;
    }

    public function collection()
    {
        return collect($this->progresses);
    }

    public function headings(): array
    {
        return [
            'Date',
            'Scope',
            'Area',
            'Position',
            'Plan Date',
            'Forecast Date',
            'Estimate Time',
            'Quantity',
            'Total Quantity',
            'Supervisor',
        ];
    }

    public function map($progress): array
    {
        return [
            $progress['date'],
            $progress['activity']['scope']['name'] ?? '',
            $progress['activity']['area']['name'] ?? '',
            $progress['activity']['position']['name'] ?? '',
            $progress['activity']['plan_date'],
            $progress['activity']['forecast_date'],
            $progress['activity']['total_estimate'] .' Day',
            $progress['quantity'] ?? 0,
            $progress['activity']['total_quantity'] ?? 0,
            $progress['activity']['supervisor']['name'] ?? '',
        ];
    }
}
