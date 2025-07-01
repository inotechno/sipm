<?php

namespace App\Livewire\Dashboard;

use App\Models\MonitoringPresent;
use App\Models\MonitoringPresentDetail;
use App\Models\Shift;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class MonitoringSupervisor extends Component
{
    public $date;
    public $data = [];
    public $shift;
    public $shift_id;
    public $dateString;
    public $timeTypes = ['7', '9', '15', '17', '19', '21', '3', '5'];
    public $totals = [];
    public $selectedTime;
    public $selectedGroupId;
    public $selectedType;
    public $selectedSupervisor;
    public $showModal = false;
    public $employeeData = [];

    public function mount($date)
    {
        $this->date = $date;
        $this->dateString = Carbon::parse($date)->format('d F Y');
        $this->shift = Shift::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->shift->id;
        $this->generateData();

        // dd($this->data);
    }

    #[On('updatedData')]
    public function updatedDate($date)
    {
        $this->date = $date;

        $this->dateString = Carbon::parse($date)->format('d F Y');

        $this->shift = Shift::where('day_of_week', strtolower(Carbon::parse($this->date)->format('l')))->first();
        $this->shift_id = $this->shift->id;

        $this->generateData();
    }

    public function generateData()
    {
        // Ambil data monitoring dengan relasi grup dan detail
        $monitoring = MonitoringPresent::with(['group.supervisor', 'details'])
            ->select('group_id', 'type')
            ->withCount([
                'details as hadir_count' => function ($query) {
                    $query->where('is_present', 1);
                },
                'details as sakit_count' => function ($query) {
                    $query->where('reason', 'sakit');
                },
                'details as tanpa_keterangan_count' => function ($query) {
                    $query->where('reason', 'tanpa_keterangan');
                },
                'details as pindah_supervisor_count' => function ($query) {
                    $query->where('reason', 'pindah_supervisor');
                },
                'details as cuti_count' => function ($query) {
                    $query->where('reason', 'cuti');
                },
                'details as training_count' => function ($query) {
                    $query->where('reason', 'training');
                },
            ])
            ->where('role', 'supervisor')
            ->whereDate('shift_date', $this->date)
            ->get()
            ->groupBy('group_id');

        $this->totals = [];

        foreach ($this->timeTypes as $type) {
            $formattedTime = str_pad($type, 2, '0', STR_PAD_LEFT);
            $this->totals[$formattedTime] = [
                'H' => 0,
                'S' => 0,
                'TK' => 0,
                'PS' => 0,
                'C' => 0,
                'T' => 0
            ];
        }

        // Format data untuk tabel
        $this->data = $monitoring->map(function ($group, $groupId) {
            $groupName = optional($group->first()->group)->name; // Ambil nama grup dari relasi
            $supervisorName = optional($group->first()->group->supervisor)->name;
            $types = $group->groupBy('type'); // Kelompokkan berdasarkan tipe

            // Format data untuk setiap tipe
            return [
                'group_id' => $groupId,
                'group_name' => $groupName,
                'supervisor_name' => $supervisorName,
                'types' => collect($this->timeTypes)->mapWithKeys(function ($type) use ($types) {
                    // Ubah tipe menjadi dua digit (pad dengan 0 jika perlu)
                    $formattedTime = str_pad($type, 2, '0', STR_PAD_LEFT);

                    // Ambil data berdasarkan tipe
                    $typeData = $types->get((int) $formattedTime, collect()); // Pastikan pencocokan tipe dalam format integer
                    // Hitung total untuk masing-masing kategori
                    $hadir = $typeData->sum('hadir_count');
                    $sakit = $typeData->sum('sakit_count');
                    $tanpaKeterangan = $typeData->sum('tanpa_keterangan_count');
                    $pindahSupervisor = $typeData->sum('pindah_supervisor_count');
                    $cuti = $typeData->sum('cuti_count');
                    $training = $typeData->sum('training_count');

                    // Tambahkan ke total
                    $this->totals[$formattedTime]['H'] += $hadir;
                    $this->totals[$formattedTime]['S'] += $sakit;
                    $this->totals[$formattedTime]['TK'] += $tanpaKeterangan;
                    $this->totals[$formattedTime]['PS'] += $pindahSupervisor;
                    $this->totals[$formattedTime]['C'] += $cuti;
                    $this->totals[$formattedTime]['T'] += $training;

                    return [
                        $formattedTime => [
                            'H' => $hadir,
                            'S' => $sakit,
                            'TK' => $tanpaKeterangan,
                            'PS' => $pindahSupervisor,
                            'C' => $cuti,
                            'T' => $training
                        ],
                    ];
                }),
            ];
        });
    }

    public function showDetail($group_id, $time, $type, $supervisor)
    {
        $this->selectedTime = $time;
        $this->selectedType = $type;
        $this->selectedGroupId = $group_id;
        $this->selectedSupervisor = $supervisor;

        $this->employeeData = MonitoringPresentDetail::with('employee')->whereHas('monitoringPresent', function ($query) use ($group_id, $time, $type) {
            $query->where('group_id', $group_id)
                ->where('type', $time);

            if ($type == 'H') {
                $query->where('is_present', 1);
            } elseif ($type == 'TK') {
                $query->where('reason', 'tanpa_keterangan');
            } elseif ($type == 'PS') {
                $query->where('reason', 'pindah_supervisor');
            } elseif ($type == 'C') {
                $query->where('reason', 'cuti');
            } elseif ($type == 'T') {
                $query->where('reason', 'training');
            } elseif ($type == 'S') {
                $query->where('reason', 'sakit');
            }

            $query->where('role', 'supervisor')
                ->whereDate('shift_date', $this->date);
        })->get();

        // dd($this->employeeData, $this->selectedGroupId, $this->selectedTime, $this->selectedType);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function formatTime($type)
    {
        return str_pad($type, 2, '0', STR_PAD_LEFT) . ':00';
    }

    public function render()
    {
        return view('livewire.dashboard.monitoring-supervisor', [
            'monitoringData' => $this->data
        ]);
    }
}
