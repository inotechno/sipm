<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InventoryImport implements ToModel, SkipsEmptyRows, WithStartRow, WithMultipleSheets
{
    use Importable;

    public $successCount = 0;
    public $failureCount = 0;
    public $errors = [];

    public function model(array $row)
    {
        try {
            DB::transaction(function () use ($row) {
                $name = $row[0];
                $category_id = $row[1];
                $warehouse_id = $row[2];
                $serial_number = $row[3];
                $purchase_date = $row[4];
                $condition = $row[5];
                $unit = $row[6];
                $stock = $row[7];
                $price = $row[8];
                $type = $row[9];

                // Lakukan validasi manual untuk data yang diperlukan
                if (empty($name) || empty($category_id) || empty($warehouse_id) || empty($serial_number) || empty($purchase_date) || empty($condition) || empty($unit) || empty($stock) || empty($price) || empty($type)) {
                    throw new \Exception("Name, Category ID, Warehouse ID, Serial Number, Purchase Date, Condition, Unit, Stock, Price, or Type cannot be empty.");
                }

                // Cek apakah tanggal valid
                $purchase_date_convert = $this->convertExcelDate($purchase_date);

                if (!$purchase_date_convert) {
                    throw new \Exception("Invalid date format: " . $purchase_date_convert);
                }

                // Simpan data ke dalam database
                \App\Models\Inventory::create([
                    'name' => $name,
                    'category_id' => $category_id,
                    'warehouse_id' => $warehouse_id,
                    'serial_number' => $serial_number,
                    'purchase_date' => $purchase_date_convert,
                    'condition' => $condition,
                    'unit' => $unit,
                    'stock' => $stock,
                    'price' => $price,
                    'type' => $type,
                ]);

                $this->successCount++;
            });
        } catch (\Exception $e) {
            DB::rollBack();
            $this->failureCount++;
            $this->errors[] = 'Baris ' . ($this->successCount + $this->failureCount + 1) . ': ' . $e->getMessage();
        }
    }

    private function convertExcelDate($purchase_date)
    {
        if (empty($purchase_date)) {
            return null; // Kembalikan null jika nilai kosong
        }

        // Pastikan nilai adalah numerik
        if (!is_numeric($purchase_date)) {
            \Log::warning('Invalid Excel date purchase date: ' . $purchase_date);
            return null;
        }

        // Konversi ke format Y-m-d
        $unixTimestamp = ($purchase_date - 25569) * 86400;
        return gmdate('Y-m-d', $unixTimestamp);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
