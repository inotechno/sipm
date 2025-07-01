<?php

namespace App\Exports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ActivitySheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents
{
    use RegistersEventListeners;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Activity::select('scope_id', 'area_id','position_id','total_estimate','forecast_date','plan_date','actual_date','supervisor_id','description')->get();
    }

    public function headings(): array
    {
        return [
            'Scope ID',
            'Area ID',
            'Position ID',
            'Supervisor ID',
            'Total Estimate',
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
            $this->convertToExcelDate($activity->forecast_date),
            $this->convertToExcelDate($activity->plan_date),
            $this->convertToExcelDate($activity->actual_date),
            $activity->description,
        ];
    }

   /**
    * Mengonversi tanggal ke format Excel agar dikenali sebagai DATE
    */
    private function convertToExcelDate($date)
    {
        return $date ? ExcelDate::stringToExcel(\Carbon\Carbon::parse($date)->format('Y-m-d')) : null;
    }

    /**
    * Event Listener untuk memastikan format berlaku hingga ke bawah
    */
    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $highestRow = 1000; // Dapatkan baris terakhir yang digunakan

        // Atur format kolom untuk semua baris, termasuk yang kosong
        $sheet->getStyle("F2:F$highestRow")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
        $sheet->getStyle("G2:G$highestRow")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
        $sheet->getStyle("H2:H$highestRow")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
    }

    public function title(): string
    {
        return 'Activities';
    }
}
