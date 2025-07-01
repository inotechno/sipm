<?php

namespace App\Livewire\Inventory;

use App\Exports\InventoryExport;
use App\Models\CategoryInventory;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class InventoryImport extends Component
{
    use LivewireAlert, WithFileUploads;

    public $relations;
    public $data;
    public $filterRelasi;
    public $file;
    public $readyToImport = false;

    protected $rules = [
        'file' => 'required|mimes:xlsx,csv|max:10240', // Maksimum 10MB
    ];

    protected $messages = [
        'file.required' => 'File harus diisi.',
        'file.mimes' => 'Format file harus .xlsx atau .csv.',
        'file.max' => 'Ukuran file maksimal 10MB.',
    ];

    public function updatedFilterRelasi($value)
    {
        switch ($value) {
            case 'category':
                $this->relations = CategoryInventory::all();
                break;
            case 'warehouse':
                $this->relations = Warehouse::all();
                break;
            default:
                $this->relations = [];
        }
    }

    public function resetForm()
    {
        $this->file = null;
        $this->readyToImport = false;
    }

    public function preview()
    {
        $this->validate();

        try {
            // Mengambil data dari file Excel
            $import = new \App\Imports\InventoryImport();
            $rows = Excel::toArray($import, $this->file)[0] ?? [];

            // Hapus header jika ada
            if (!empty($rows) && isset($rows[0][0]) && strtolower($rows[0][0]) === 'scope id') {
                array_shift($rows);
            }

            // Filter baris yang kosong
            $filteredRows = array_filter($rows, function ($row) {
                // Pastikan setidaknya satu kolom memiliki data
                return !empty($row[0]) || !empty($row[1]) || !empty($row[2]) || !empty($row[3]);  // Sesuaikan kolom mana yang perlu dicek
            });

            // Ambil semua ID dari sheet
            $categoryIds = array_column($filteredRows, 1);
            $warehouseIds = array_column($filteredRows, 2);

            // Ambil nama dari relasi berdasarkan ID
            $categories = CategoryInventory::whereIn('id', $categoryIds)->pluck('name', 'id');
            $warehouses = Warehouse::whereIn('id', $warehouseIds)->pluck('name', 'id');

            // Format ulang data agar menampilkan nama dari ID
            $this->data = array_map(function ($row) use ($categories, $warehouses) {
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

                return [
                    'name' => $name,
                    'category_id' => $categories[$category_id] ?? $category_id,
                    'category_name' => $categories[$category_id] ?? 'N/A',
                    'warehouse_id' => $warehouses[$warehouse_id] ?? $warehouse_id,
                    'warehouse_name' => $warehouses[$warehouse_id] ?? 'N/A',
                    'serial_number' => $serial_number,
                    'purchase_date' => $this->formatDate($purchase_date),
                    'condition' => $condition,
                    'unit' => $unit,
                    'stock' => $stock,
                    'price' => $price,
                    'type' => $type,
                ];
            }, $filteredRows);

            $this->readyToImport = !empty($this->data);
        } catch (\Exception $e) {
            $this->alert('error', 'Terjadi kesalahan saat membaca file: ' . $e->getMessage());
            $this->reset(['file', 'data', 'readyToImport']);
        }
    }

    public function import()
    {
        if ($this->readyToImport) {
            // Inisialisasi ActivityImport untuk mendapatkan error dan data yang berhasil
            $import = new \App\Imports\InventoryImport();
            $import->import($this->file);

            if ($import->errors) {
                $this->alert(
                    'error',
                    'Berhasil diproses: ' . $import->successCount .
                    ' baris.<br>Gagal diproses: ' . $import->failureCount .
                    ' baris.<br>Gagal mengimport data.
                ' . implode(
                        '<br>',
                        $import->errors
                    ),
                    [
                        'position' => 'center',
                        'timer' => false,
                        'toast' => false,
                        'showConfirmButton' => true
                    ]
                );
            } else {
                $this->alert(
                    'success',
                    "Berhasil diproses: " . $import->successCount .
                    " baris.<br>Gagal diproses: " . $import->failureCount . " baris.",
                    [
                        'position' => 'center',
                        'timer' => false,
                        'toast' => false,
                        'showConfirmButton' => true
                    ]
                );
            }

            // $this->reset(['file', 'data', 'readyToImport']);
            // $this->resetForm();
        }
        // try {
        // } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        //     // Menangani exception khusus untuk validasi jika terjadi
        //     $this->alert('error', 'Terjadi kesalahan saat memvalidasi data: ' . $e->getMessage());
        // } catch (\Exception $e) {
        //     // Menangani error lain yang tidak terduga
        //     $this->alert('error', 'Terjadi kesalahan: ' . $e->getMessage());
        // }
    }

    private function formatDate($date)
    {
        // Cek apakah tanggal adalah serial number dari Excel
        if (is_numeric($date) && $date > 0) {
            // Excel menggunakan serial number untuk tanggal. Konversi ke format yang dapat dibaca oleh Carbon.
            return \Carbon\Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($date)->format('Y-m-d');
        }

        // Jika tidak berupa angka, coba parsing dengan Carbon (untuk format standar seperti Y-m-d)
        try {
            return $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : null;
        } catch (\Exception $e) {
            // Jika gagal, log error
            \Log::error("Gagal memformat tanggal: " . $date);
            return null;
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new InventoryExport, 'Activity Template Import.xlsx');
    }

    public function render()
    {
        return view('livewire.inventory.inventory-import')->layout('layouts.app-inventory', ['title' => 'Import Inventory']);
    }
}
