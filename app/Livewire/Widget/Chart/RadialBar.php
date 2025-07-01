<?php

namespace App\Livewire\Widget\Chart;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class RadialBar extends Component
{
    public $labels = [];
    public $chart_id;
    public $height = 200;
    public $series = [];
    public $colors = ['rgba(255, 99, 71, 1)'];

    public function mount($chart_id, $series, $colors = [], $labels = [])
    {
        $this->labels = $labels ?? [];
        $this->chart_id = $chart_id;
        $this->series = $series;

        $this->colors = $colors ?? ['rgba(255, 99, 71, 1)'];
    }

    public function render()
    {
        return view('livewire.widget.chart.radial-bar');
    }
}
