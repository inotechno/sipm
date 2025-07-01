<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PositionSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Position::select('id', 'name')->get();
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
        return 'Positions';
    }
}
