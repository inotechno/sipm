<?php

namespace App\Livewire\Employee;

use App\Exports\EmployeeExport;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;


class EmployeeImport extends Component
{
    use LivewireAlert, WithFileUploads;

    public $file;

    public function downloadTemplate()
    {
       return Excel::download(new EmployeeExport, 'employees.xlsx');
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        try {
            Excel::import(new \App\Imports\EmployeeImport, $this->file);
            $this->alert('success', 'Data Imported Successfully');
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-import');
    }
}
