<?php

namespace App\Livewire\FileManager;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FileManagerDisk extends Component
{
    public $diskUsage;
    public $diskSpace =  100000000000;
    public $percentage = 0;
    public $textDisk = '';
    public $categories;

    public function mount()
    {
        $this->diskUsage = File::getTotalDiskUsage();
        $this->percentage = round($this->diskUsage / $this->diskSpace * 100, 2);

        $this->textDisk = $this->formatSizeUnits($this->diskUsage) . ' (' . $this->percentage . '%) of 100 GB used';

        $this->categories = File::getFileCategories();
    }

    public function formatSizeUnits($size)
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' B';
        }
    }

    public function render()
    {
        return view('livewire.file-manager.file-manager-disk');
    }
}
