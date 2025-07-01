<?php

namespace App\Exports;

use App\Models\Area;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AreaSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Area::select('id', 'name')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
        ];
    }

    public function title(): string
    {
        return 'Areas';
    }
}
