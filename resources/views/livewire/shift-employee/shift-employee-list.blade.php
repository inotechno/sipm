<div>
    <div class="card job-filter">
        <div class="card-body">
            <form action="javascript:void(0);">
                <div class="row g-3">
                    <div class="col-lg form-floating">
                        <select class="form-select" id="selectEmployee" wire:model="filterEmployee">
                            <option selected value="">-- Select Employee --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        <label for="selectEmployee">Filter Select Employee</label>
                    </div>
                    <div class="col-lg form-floating">
                        <select class="form-select" id="selectGroup" wire:model="filterGroup">
                            <option selected value="">-- Select Group --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <label for="selectGroup">Filter Select Group</label>
                    </div>
                    <div class="col-lg form-floating">
                        <select class="form-select" id="selectPosition" wire:model="filterPosition">
                            <option selected value="">-- Select Position --</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        <label for="selectPosition">Filter Select Position</label>
                    </div>
                    <div class="col-lg form-floating">
                        <input type="date" class="form-control" id="filterStartDate" wire:model="filterStartDate">
                        <label for="filterStartDate">Filter Start Date</label>
                    </div>
                    <div class="col-lg form-floating">
                        <input type="date" class="form-control" id="filterEndDate" wire:model="filterEndDate">
                        <label for="filterEndDate">Filter End Date</label>
                    </div>
                    <div class="col-lg">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-soft-secondary waves-effect waves-light"
                                wire:click="filter">
                                <i class="mdi mdi-filter-outline d-block font-size-16"></i> Filter
                            </button>
                            <button type="button" class="btn btn-soft-danger waves-effect waves-light"
                                wire:click="resetFilter">
                                <i class="mdi mdi-refresh d-block font-size-16"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </form>
        </div>
    </div>

    <div class="card job-filter">
        <div class="card-body">
            <h4 class="card-title mb-4">Schedule Date On {{ $dateRange[0] }} to {{ $dateRange[count($dateRange) - 1] }}</h4>
            <div class="table-responsive" style="height: 500px;overflow: auto">
                <table class="table align-middle table-nowrap mb-0 table-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle">ID</th>
                            <th class="align-middle">Employee</th>
                            @foreach ($dateRange as $date)
                                <th class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($date)->format('D') }}</br>
                                    {{ \Carbon\Carbon::parse($date)->format('d/m') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{ $schedule->name }}</td>
                                @foreach ($schedule->schedules_by_date as $date => $shiftName)
                                    <td class="text-center">
                                        <a href="javascript:void(0);"
                                            wire:click="$dispatch('editShift', {employeeId:{{ $schedule->id }}, date:'{{ $date }}'})"
                                            class="badge @if ($shiftName == 'Shift 1') badge-soft-success @elseif($shiftName == 'Shift 2') badge-soft-warning @else badge-soft-danger @endif">
                                            {{ $shiftName }}
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @livewire('shift-employee.shift-employee-edit-shift', key('shift-employee-edit-shift'))
</div>
