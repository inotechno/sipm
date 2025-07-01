<div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Monitoring Present By Supervisor Date {{ $dateString }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12" wire:loading>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 table-responsive" wire:loading.remove>
                    <table class="table table-bordered align-middle table-sm">
                        <thead>
                            <tr class="text-center align-middle">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Group</th>
                                <th rowspan="2">Supervisor</th>
                                @foreach ($timeTypes as $index => $type)
                                    <th scope="col" colspan="6">
                                        {{ str_pad($type, 2, '0', STR_PAD_LEFT) . ':00' }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="text-center align-middle">
                                @foreach ($timeTypes as $type)
                                    <th class="text-center">H</th>
                                    <th class="text-center">S</th>
                                    <th class="text-center">TK</th>
                                    <th class="text-center">PS</th>
                                    <th class="text-center">C</th>
                                    <th class="text-center">T</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoringData as $group)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="">{{ $group['group_name'] }}</td>
                                    <td class="">{{ $group['supervisor_name'] }}</td>
                                    @foreach ($group['types'] as $time => $typeData)
                                        <td class="text-center">
                                            @if ($typeData['H'] == 0)
                                                <span>0</span>
                                            @else
                                                <a href="javascript:void(0)"
                                                    wire:click="showDetail({{ $group['group_id'] }}, {{ $time }}, 'H', '{{ $group['supervisor_name'] }}')">{{ $typeData['H'] }}</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($typeData['S'] == 0)
                                                <span>0</span>
                                            @else
                                                <a class="@if ($typeData['S'] == 0) text-danger @endif"
                                                    href="javascript:void(0)"
                                                    wire:click="showDetail({{ $group['group_id'] }}, {{ $time }}, 'S', '{{ $group['supervisor_name'] }}')">{{ $typeData['S'] }}</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($typeData['TK'] == 0)
                                                <span>0</span>
                                            @else
                                                <a class="@if ($typeData['TK'] == 0) text-danger @endif"
                                                    href="javascript:void(0)"
                                                    wire:click="showDetail({{ $group['group_id'] }}, {{ $time }}, 'TK', '{{ $group['supervisor_name'] }}')">{{ $typeData['TK'] }}</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($typeData['PS'] == 0)
                                                <span>0</span>
                                            @else
                                                <a class="@if ($typeData['PS'] == 0) text-danger @endif"
                                                    href="javascript:void(0)"
                                                    wire:click="showDetail({{ $group['group_id'] }}, {{ $time }}, 'PS', '{{ $group['supervisor_name'] }}')">{{ $typeData['PS'] }}</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($typeData['C'] == 0)
                                                <span>0</span>
                                            @else
                                                <a class="@if ($typeData['C'] == 0) text-danger @endif"
                                                    href="javascript:void(0)"
                                                    wire:click="showDetail({{ $group['group_id'] }}, {{ $time }}, 'C', '{{ $group['supervisor_name'] }}')">{{ $typeData['C'] }}</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($typeData['T'] == 0)
                                                <span>0</span>
                                            @else
                                                <a class="@if ($typeData['T'] == 0) text-danger @endif"
                                                    href="javascript:void(0)"
                                                    wire:click="showDetail({{ $group['group_id'] }}, {{ $time }}, 'T', '{{ $group['supervisor_name'] }}')">{{ $typeData['T'] }}</a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="3">Total</th>
                                @foreach ($timeTypes as $type)
                                    @php $formattedTime = str_pad($type, 2, '0', STR_PAD_LEFT); @endphp
                                    <th class="text-center">{{ $totals[$formattedTime]['H'] }}</a></th>
                                    <th class="text-center">{{ $totals[$formattedTime]['S'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['TK'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['PS'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['C'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['T'] }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-12 mt-2">
                    <p class="text-muted font-size-10">Keterangan : <br>
                        H = Hadir <br>
                        S = Sakit <br>
                        TK = Tanpa Keterangan <br>
                        PS = Pindah Supervisor <br>
                        C = Cuti <br>
                        T = Training
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if ($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Employee List {{ $selectedSupervisor }} Type
                            {{ $selectedType . ' (' . $selectedTime . ')' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 600px; overflow-y: scroll;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Note/Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($employeeData))
                                    @foreach ($employeeData as $data)
                                        <tr>
                                            <td>{{ $data->employee->name }}</td>
                                            <td>
                                                Reason: {{ strtoupper(str_replace('_', ' ', $data->reason)) }}
                                                {{ $data->reason == 'pindah_supervisor' ? ' (' . $data->moveSupervisor?->name . ')' : '' }}
                                                <br> Note: {{ $data->note != '' ? $data->note : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
