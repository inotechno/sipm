<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class InventorySheet implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::select('id', 'name', 'category_id', 'warehouse_id', 'serial_number','purchase_date', 'condition','unit','stock','price','type')->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Category ID',
            'Warehouse ID',
            'Serial Number',
            'Purchase Date',
            'Condition',
            'Unit',
            'Stock',
            'Price',
            'Type',
        ];
    }

    public function title(): string
    {
        return 'Inventory';
    }

    public function map($inventory): array
    {
        return [
            $inventory->name,
            $inventory->category_id,
            $inventory->warehouse_id,
            $inventory->serial_number,
            $this->formatDate($inventory->purchase_date),
            $inventory->condition,
            $inventory->unit,
            $inventory->stock,
            $inventory->price,
            $inventory->type,
        ];
    }

    private function formatDate($date)
    {
        return $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : null;
    }
}
