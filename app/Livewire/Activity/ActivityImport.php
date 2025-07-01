<?php

namespace App\Livewire\Activity;

use App\Exports\ActivityExport;
use App\Models\Area;
use App\Models\Group;
use App\Models\Position;
use App\Models\Scope;
use App\Models\StatusActivity;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ActivityImport extends Component
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
            case 'area':
                $this->relations = Area::all();
                break;
            case 'position':
                $this->relations = Position::all();
                break;
            case 'scope':
                $this->relations = Scope::all();
                break;
            case 'group':
                $this->relations = Group::all();
                break;
            case 'status':
                $this->relations = StatusActivity::whereNot('id', 4)->get();
                break;
            case 'supervisor':
                $this->relations = User::role('Supervisor')->get();
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
            $import = new \App\Imports\ActivityImport();
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
            $scopeIds = array_column($filteredRows, 0);
            $areaIds = array_column($filteredRows, 1);
            $positionIds = array_column($filteredRows, 2);
            $supervisorIds = array_column($filteredRows, 3);

            // Ambil nama dari relasi berdasarkan ID
            $scopes = Scope::whereIn('id', $scopeIds)->pluck('name', 'id');
            $areas = Area::whereIn('id', $areaIds)->pluck('name', 'id');
            $positions = Position::whereIn('id', $positionIds)->pluck('name', 'id');
            $supervisors = User::whereIn('id', $supervisorIds)->pluck('name', 'id');

            // Format ulang data agar menampilkan nama dari ID
            $this->data = array_map(function ($row) use ($scopes, $areas, $positions, $supervisors) {
                return [
                    'scope_id' => $row[0] ?? null,
                    'scope_name' => $scopes[$row[0]] ?? 'Unknown',
                    'area_id' => $row[1] ?? null,
                    'area_name' => $areas[$row[1]] ?? 'Unknown',
                    'position_id' => $row[2] ?? null,
                    'position_name' => $positions[$row[2]] ?? 'Unknown',
                    'supervisor_id' => $row[3] ?? null,
                    'supervisor_name' => $supervisors[$row[3]] ?? 'Unknown',
                    'total_estimate' => $row[4] ?? null,
                    'forecast_date' => $this->formatDate($row[5]) ?? null,
                    'plan_date' => $this->formatDate($row[6]) ?? null,
                    'actual_date' => $this->formatDate($row[7]) ?? null,
                    'description' => $row[8] ?? null,
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
            $import = new \App\Imports\ActivityImport();
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

            $this->reset(['file', 'data', 'readyToImport']);
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
        return Excel::download(new ActivityExport, 'Activity Template Import.xlsx');
    }
    public function render()
    {
        return view('livewire.activity.activity-import')->layout('layouts.app', ['title' => 'Import Activity']);
    }
}
