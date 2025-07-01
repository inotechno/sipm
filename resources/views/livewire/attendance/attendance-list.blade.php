<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-lg-6">
                                @livewire(
                                    'component.form.select2',
                                    [
                                        'label' => 'Filter Employee',
                                        'model' => 'filterEmployee',
                                        'options' => $employees->map(fn($e) => ['value' => $e->id, 'text' => $e->name])->toArray(),
                                        'selected' => $filterEmployee,
                                        'placeholder' => '-- Select Employee --',
                                        'multiple' => true,
                                    ],
                                    key('filterEmployee')
                                )
                            </div>
                            <div class="col-xxl-2 col-lg-6">
                                @livewire(
                                    'component.form.select2',
                                    [
                                        'label' => 'Filter Group',
                                        'model' => 'filterGroup',
                                        'options' => $groups->map(fn($e) => ['value' => $e->id, 'text' => $e->name . ' | ' . $e->supervisor->name])->toArray(),
                                        'selected' => $filterGroup,
                                        'placeholder' => '-- Select Group --',
                                        'multiple' => true,
                                    ],
                                    key('filterGroup')
                                )
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                @livewire(
                                    'component.form.select2',
                                    [
                                        'label' => 'Filter Position',
                                        'model' => 'filterPosition',
                                        'options' => $positions->map(fn($e) => ['value' => $e->id, 'text' => $e->name])->toArray(),
                                        'selected' => $filterPosition,
                                        'placeholder' => '-- Select Position --',
                                        'multiple' => true,
                                    ],
                                    key('filterPosition')
                                )
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <label for="filterStartDate">Filter Start Date</label>
                                <input type="date" class="form-control" id="filterStartDate"
                                    wire:model="filterStartDate">
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <label for="filterEndDate">Filter End Date</label>
                                <input type="date" class="form-control" id="filterEndDate"
                                    wire:model="filterEndDate">
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <div class="d-flex gap-2">
                                    <button type="button"
                                        class="btn btn-soft-secondary waves-effect waves-light flex-grow-1"
                                        wire:click="filter">
                                        <i class="mdi mdi-filter-outline d-block font-size-16"></i> Filter
                                    </button>
                                    <button type="button"
                                        class="btn btn-soft-danger waves-effect waves-light flex-grow-1"
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
        </div>
    </div>

    <div class="row gy-2 gx-3 mb-2 align-items-center justify-content-between">
        <div class="col-sm-auto">
            <select class="form-select" id="selectLimit" wire:model.live="perPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>

        @hasrole('Super Admin')
            <div class="col-sm-auto">
                <form wire:submit.prevent="import" class="needs-validation" novalidate>
                    <div class="d-flex gap-2 align-items-center">
                        <div class="flex-grow-1">
                            <a href="javascript: void(0);" class="btn btn-info" wire:click="downloadTemplate">Template</a>
                        </div>
                        <div class="flex-shrink-0">
                            <input type="file" class="form-control @error('file') is-invalid @enderror" wire:model="file"
                                id="formrow-file-input" placeholder="Enter File" autocomplete="off">

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="flex-shrink-1">
                            <button type="submit" class="btn btn-primary w-md" wire:loading.attr="disabled"
                                wire:target="file">Submit</button>
                            <button type="reset" class="btn btn-secondary w-md" wire:click="resetForm"> Reset</button>
                        </div>
                    </div>

                </form>
            </div>
        @endhasrole
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Employee ID</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Machine SN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $attendance->employee_id }}</td>
                                        <td>{{ $attendance->employee->name }}</td>
                                        <td>{{ $attendance->dateString }}</td>
                                        <td>{{ $attendance->time }}</td>
                                        <td>{{ $attendance->employee?->group?->name }}</td>
                                        <td>{{ $attendance->employee?->position?->name }}</td>
                                        <td>
                                            {{ $attendance->shift->name }}
                                        </td>
                                        <td>{{ $attendance->machine_sn }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="col-lg-12">
                            {{ $attendances->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
