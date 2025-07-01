<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InventoryExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new InventorySheet(),
            new WarehouseSheet(),
            new CategoryInventorySheet(),
        ];
    }
}
