<?php

namespace App\Livewire\Report;

use App\Exports\ReportExport;
use App\Exports\ReportPdf;
use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ReportPreview extends Component
{
    public $activities = [];

    #[On('refreshActivities')]
    public function refreshActivities($activities)
    {
        $this->reset('activities');
        $this->activities = $activities;
    }

    public function exportExcel()
    {
        return Excel::download(new ReportExport($this->activities), 'Report Activities.xlsx');
    }

    public function exportPdf()
    {
        $pdf = Pdf::loadView('exports.activity-report', [
            'activities' => $this->activities,
            'generated_at' => Carbon::now()->format('d F Y H:i:s')
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        return response()->streamDownload(function () use ($pdf) { echo $pdf->stream(); }, 'Report Activities.pdf');
    }

    public function render()
    {
        return view('livewire.report.report-preview');
    }
}
