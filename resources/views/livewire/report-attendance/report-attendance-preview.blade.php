<div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between">
                <div class="flex-shrink-0">
                    {{-- Button Group --}}
                    <button wire:click="toggleSort" class="btn btn-primary">
                        Sort by Attendance ({{ $sortByAttendance === 'asc' ? 'Least to Most' : 'Most to Least' }})
                    </button>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-success waves-effect btn-label waves-light"
                        wire:click="exportExcel" wire:loading.attr="disabled"><i
                            class="fas fa-file-excel label-icon"></i>
                        Excel</button>
                    <button type="button" class="btn btn-danger waves-effect btn-label waves-light"
                        wire:click="exportPdf" wire:loading.attr="disabled"><i class="fas fa-file-pdf label-icon"></i>
                        PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="spinner-border text-dark m-1" wire:loading>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <h4 class="card-title mb-5">Preview Attendance</h4>
                    <div class="table-responsive" wire:loading.remove>
                        <table class="table table-bordered table-hover align-middle table-sm">
                            <thead class="align-middle">
                                <tr>
                                    <th rowspan="2">Employee ID</th>
                                    <th rowspan="2">Name</th>
                                    <th rowspan="2">Supervisor</th>
                                    <th rowspan="2">Position</th>
                                    <th rowspan="2">Phone</th>
                                    <th rowspan="2">Shift</th>
                                    <th class="text-center" colspan="{{ $countDays }}">Tanggan/Bulan</th>
                                </tr>
                                <tr>
                                    @empty(!$employees)
                                        @foreach ($dateArray as $date)
                                            <th class="text-center">{{ \Carbon\Carbon::parse($date)->format('d/m') }}</th>
                                        @endforeach
                                    @endempty
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @empty(!$employees)
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee['employee_id'] }}</td>
                                            <td>{{ $employee['name'] }}</td>
                                            <td>{{ $employee['supervisor_name'] ?? '-' }}</td>
                                            <td>{{ $employee['position_name'] ?? '-' }}</td>
                                            <td>{{ $employee['phone'] ?? '-' }}</td>
                                            <td>{{ $employee['shift'] ?? '-' }}</td>
                                            @foreach ($employee['attendance'] as $date => $timeRange)
                                                <td>{{ $timeRange }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endempty
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
