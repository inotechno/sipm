<?php

namespace App\Imports;

use App\Models\Activity;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ActivityEmployee;
use App\Models\Group;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ActivityImport implements ToModel, SkipsEmptyRows, WithStartRow, WithMultipleSheets
{
    use Importable;

    public $successCount = 0;
    public $failureCount = 0;
    public $errors = [];

    public function model(array $row)
    {
        try {
            DB::transaction(function () use ($row) {
                $scope_id = $row[0];
                $area_id = $row[1];
                $position_id = $row[2];
                $supervisor_id = $row[3];
                $total_estimate = $row[4];
                $total_quantity = $row[5];
                $forecast_date = $row[6];
                $plan_date = $row[7];
                $actual_date = $row[8];
                $description = $row[9];

                // Lakukan validasi manual untuk data yang diperlukan
                if (empty($scope_id) || empty($area_id) || empty($position_id)) {
                    throw new \Exception("Scope, Area, or Position ID cannot be empty.");
                }

                // Cek apakah tanggal valid
                $forecast_date_convert = $this->convertExcelDate($forecast_date);
                $plan_date_convert = $this->convertExcelDate($plan_date);
                $actual_date_convert = $this->convertExcelDate($actual_date);

                if (!$forecast_date_convert || !$plan_date_convert) {
                    throw new \Exception("Invalid date format: " . $forecast_date_convert . ", " . $plan_date_convert . ", " . $actual_date_convert);
                }

                // Cari group berdasarkan supervisor_id
                $group = Group::where('supervisor_id', $supervisor_id)->first();
                if (!$group) {
                    throw new \Exception("Group not found for supervisor ID: $supervisor_id.");
                }

                // Simpan Activity
                $activity = Activity::create([
                    'scope_id' => $scope_id,
                    'area_id' => $area_id,
                    'position_id' => $position_id,
                    'total_estimate' => $total_estimate,
                    'forecast_date' => $forecast_date_convert,
                    'plan_date' => $plan_date_convert,
                    'actual_date' => $actual_date_convert,
                    'total_quantity' => $total_quantity,
                    'supervisor_id' => $supervisor_id,
                    'description' => $description,
                    'status_id' => 3,
                ]);

                // Tambahkan Employee ke ActivityEmployee
                foreach ($group->employees as $employee) {
                    ActivityEmployee::create([
                        'activity_id' => $activity->id,
                        'employee_id' => $employee->id,
                    ]);
                }

                $this->successCount++;
            });
        } catch (\Exception $e) {
            DB::rollBack();
            $this->failureCount++;
            // Menyimpan error beserta nomor baris yang gagal
            $this->errors[] = "Row " . ($this->failureCount + $this->successCount) . " failed: " . $e->getMessage();
        }
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

    private function convertExcelDate($serialNumber)
    {
        if (empty($serialNumber)) {
            return null; // Kembalikan null jika nilai kosong
        }

        // Pastikan nilai adalah numerik
        if (!is_numeric($serialNumber)) {
            \Log::warning('Invalid Excel date serial number: ' . $serialNumber);
            return null;
        }

        // Konversi ke format Y-m-d
        $unixTimestamp = ($serialNumber - 25569) * 86400;
        return gmdate('Y-m-d', $unixTimestamp);
    }
}
