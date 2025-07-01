<?php

namespace App\Livewire\Report\Progress;

use App\Exports\ReportActivityProgressExport;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ReportProgressPreview extends Component
{
    public $progresses = [];

    #[On('refreshProgresses')]
    public function refreshProgresses($progresses)
    {
        $this->reset('progresses');
        $this->progresses = $progresses;
    }

    public function exportExcel()
    {
        return Excel::download(new ReportActivityProgressExport($this->progresses), 'Report Activity Progress.xlsx');
    }

    // public function exportPdf()
    // {
    //     $pdf = Pdf::loadView('exports.activity-report', [
    //         'activities' => $this->activities,
    //         'generated_at' => Carbon::now()->format('d F Y H:i:s')
    //     ]);

    //     $pdf->setPaper('a4', 'landscape');
    //     $pdf->setOption('isHtml5ParserEnabled', true);
    //     $pdf->setOption('isRemoteEnabled', true);

    //     return response()->streamDownload(function () use ($pdf) { echo $pdf->stream(); }, 'Report Activities.pdf');
    // }


    public function render()
    {
        return view('livewire.report.progress.report-progress-preview');
    }
}
