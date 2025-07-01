<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Attendance Per Division {{ $dateString }} {{ $shift->name }}</h4>
            <div class="row">
                <div class="col-12" wire:loading>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 table-responsive" wire:loading.remove>
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr class="text-center align-middle">
                                <th rowspan="2">NO</th>
                                <th rowspan="2">DIVISI</th>
                                <th colspan="3">IN</th>
                                <th colspan="3">OUT</th>
                                <th colspan="3">BREAK IN</th>
                                <th colspan="3">BREAK OUT</th>
                            </tr>
                            <tr class="text-center align-middle">
                                <th>OT</th>
                                <th>E</th>
                                <th>L</th>

                                <th>OT</th>
                                <th>E</th>
                                <th>L</th>

                                <th>OT</th>
                                <th>E</th>
                                <th>L</th>

                                <th>OT</th>
                                <th>E</th>
                                <th>L</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $totals = [
                                    'IN' => ['ontime' => 0, 'early' => 0, 'late' => 0],
                                    'OUT' => ['ontime' => 0, 'early' => 0, 'late' => 0],
                                    'BreakIN' => ['ontime' => 0, 'early' => 0, 'late' => 0],
                                    'BreakOut' => ['ontime' => 0, 'early' => 0, 'late' => 0],
                                ];
                            @endphp
                            @foreach ($attendanceData as $position => $data)
                                <tr class="text-center">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $position }}</td>
                                    <td>
                                        @if($data['IN']['ontime'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('in', 'ontime', '{{ $position }}')">
                                                {{ $data['IN']['ontime'] }}
                                            </a>
                                        @else
                                            {{ $data['IN']['ontime'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['IN']['early'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('in','early', '{{ $position }}')">
                                                {{ $data['IN']['early'] }}
                                            </a>
                                        @else
                                            {{ $data['IN']['early'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['IN']['late'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('in', 'late', '{{ $position }}')">
                                                {{ $data['IN']['late'] }}
                                            </a>
                                        @else
                                            {{ $data['IN']['late'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['OUT']['ontime'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('out', 'ontime', '{{ $position }}')">
                                                {{ $data['OUT']['ontime'] }}
                                            </a>
                                        @else
                                            {{ $data['OUT']['ontime'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['OUT']['early'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('out', 'early', '{{ $position }}')">
                                                {{ $data['OUT']['early'] }}
                                            </a>
                                        @else
                                            {{ $data['OUT']['early'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['OUT']['late'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('out', 'late', '{{ $position }}')">
                                                {{ $data['OUT']['late'] }}
                                            </a>
                                        @else
                                            {{ $data['OUT']['late'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['BreakIN']['ontime'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('break_in', 'ontime', '{{ $position }}')">
                                                {{ $data['BreakIN']['ontime'] }}
                                            </a>
                                        @else
                                            {{ $data['BreakIN']['ontime'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['BreakIN']['early'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('break_in', 'early', '{{ $position }}')">
                                                {{ $data['BreakIN']['early'] }}
                                            </a>
                                        @else
                                            {{ $data['BreakIN']['early'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['BreakIN']['late'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('break_in', 'late', '{{ $position }}')">
                                                {{ $data['BreakIN']['late'] }}
                                            </a>
                                        @else
                                            {{ $data['BreakIN']['late'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['BreakOut']['ontime'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('break_out', 'ontime', '{{ $position }}')">
                                                {{ $data['BreakOut']['ontime'] }}
                                            </a>
                                        @else
                                            {{ $data['BreakOut']['ontime'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['BreakOut']['early'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('break_out', 'early', '{{ $position }}')">
                                                {{ $data['BreakOut']['early'] }}
                                            </a>
                                        @else
                                            {{ $data['BreakOut']['early'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['BreakOut']['late'] != 0)
                                            <a href="#" wire:click.prevent="showSupervisorData('break_out', 'late', '{{ $position }}')">
                                                {{ $data['BreakOut']['late'] }}
                                            </a>
                                        @else
                                            {{ $data['BreakOut']['late'] }}
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    // Hitung total untuk setiap kolom
                                    $totals['IN']['ontime'] += $data['IN']['ontime'];
                                    $totals['IN']['early'] += $data['IN']['early'];
                                    $totals['IN']['late'] += $data['IN']['late'];

                                    $totals['OUT']['ontime'] += $data['OUT']['ontime'];
                                    $totals['OUT']['early'] += $data['OUT']['early'];
                                    $totals['OUT']['late'] += $data['OUT']['late'];

                                    $totals['BreakIN']['ontime'] += $data['BreakIN']['ontime'];
                                    $totals['BreakIN']['early'] += $data['BreakIN']['early'];
                                    $totals['BreakIN']['late'] += $data['BreakIN']['late'];

                                    $totals['BreakOut']['ontime'] += $data['BreakOut']['ontime'];
                                    $totals['BreakOut']['early'] += $data['BreakOut']['early'];
                                    $totals['BreakOut']['late'] += $data['BreakOut']['late'];
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th colspan="2">TOTAL</th>
                                <th>{{ $totals['IN']['ontime'] }}</th>
                                <th>{{ $totals['IN']['early'] }}</th>
                                <th>{{ $totals['IN']['late'] }}</th>
                                <th>{{ $totals['OUT']['ontime'] }}</th>
                                <th>{{ $totals['OUT']['early'] }}</th>
                                <th>{{ $totals['OUT']['late'] }}</th>
                                <th>{{ $totals['BreakIN']['ontime'] }}</th>
                                <th>{{ $totals['BreakIN']['early'] }}</th>
                                <th>{{ $totals['BreakIN']['late'] }}</th>
                                <th>{{ $totals['BreakOut']['ontime'] }}</th>
                                <th>{{ $totals['BreakOut']['early'] }}</th>
                                <th>{{ $totals['BreakOut']['late'] }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="col-12 mt-2">
                <p class="text-muted font-size-10">Keterangan : <br>
                    OT = On Time <br>
                    E = Early <br>
                    L = Late <br>
                </p>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan data supervisor -->
    @if ($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Total Per Supervisor ({{ strtoupper(str_replace('_', ' ', $selectedCategory)) }} {{ strtoupper($selectedType) }} -
                            {{ $selectedDivision }})</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" style="overflow-y: scroll; max-height: 500px;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Supervisor</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($supervisorData)
                                            @php
                                                $totals = 0;
                                            @endphp
                                            @foreach ($supervisorData as $supervisor => $total)
                                                <tr>
                                                    <td>{{ $supervisor }}</td>
                                                    <td>
                                                        <a href="#"
                                                            wire:click.prevent="showEmployeeData('{{ $supervisor }}')">
                                                            {{ $total }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php
                                                    $totals += $total;
                                                @endphp
                                            @endforeach
                                            <tr class="fw-bold">
                                                <td>Total</td>
                                                <td>{{ $totals }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6" style="overflow-y: scroll; max-height: 500px;">
                                @if ($employeeData && $selectedSupervisor)
                                    <h6>Daftar Karyawan di Supervisor: {{ $selectedSupervisor }}</h6>
                                    <table class="table table-bordered" wire:loading.remove>
                                        <thead>
                                            <tr>
                                                <th>Nama Karyawan</th>
                                                <th>Phone</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employeeData as $employee)
                                                <tr>
                                                    <td>{{ $employee['name'] }}</td>
                                                    <td>{{ $employee['phone'] }}</td>
                                                    <td>{{ $employee['timestamp'] ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">Klik total supervisor untuk melihat daftar karyawan.</p>
                                @endif

                                <div wire:loading wire:target="showEmployeeData">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    @push('styles')
        <style>
            .modal {
                display: none;
            }

            .modal.show {
                display: block;
            }

            .modal-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1040;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.5);
            }
        </style>
    @endpush
</div>
