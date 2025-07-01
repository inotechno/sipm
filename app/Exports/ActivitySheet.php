<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActivitySheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Activity::select('scope_id', 'area_id','position_id','total_estimate', 'total_quantity','forecast_date','plan_date','actual_date','supervisor_id','description')->get();
    }

    public function headings(): array
    {
        return [
            'Scope ID',
            'Area ID',
            'Position ID',
            'Supervisor ID',
            'Total Estimate',
            'Total Quantity',
            'Forecast Date',
            'Plan Date',
            'Actual Date',
            'Description',
        ];
    }

    public function map($activity): array
    {
        return [
            $activity->scope_id,
            $activity->area_id,
            $activity->position_id,
            $activity->supervisor_id,
            $activity->total_estimate,
            $activity->total_quantity,
            $this->formatDate($activity->forecast_date),
            $this->formatDate($activity->plan_date),
            $this->formatDate($activity->actual_date),
            $activity->description,
        ];
    }

    /**
    * Format tanggal menjadi YYYY-MM-DD
    */
    private function formatDate($date)
    {
        return $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : null;
    }

    public function title(): string
    {
        return 'Activities';
    }

}
