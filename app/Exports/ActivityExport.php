<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActivityExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ActivitySheet(),
            new AreaSheet(),
            new PositionSheet(),
            new ScopeSheet(),
            new SupervisorSheet(),
        ];
    }
}
