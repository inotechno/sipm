<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Report Attendance', 'url' => route('activity.report')]]], key('breadcrumb'))

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
                                <label for="filterShift">Filter Shift</label>
                                <select wire:model="filterShift" class="form-control form-select" id="">
                                    <option value="">All</option>
                                    <option value="1">Shift 1</option>
                                    <option value="2">Shift 2</option>
                                </select>
                                @error('filterShift')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-xxl-1 col-lg-4">
                                <label for="filterStartDate">Filter Start Date</label>
                                <input type="date" class="form-control @error('filterStartDate') is-invalid @enderror" id="filterStartDate"
                                    wire:model="filterStartDate">

                                @error('filterStartDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xxl-1 col-lg-4">
                                <label for="filterEndDate">Filter End Date</label>
                                <input type="date" class="form-control @error('filterEndDate') is-invalid @enderror" id="filterEndDate"
                                    wire:model="filterEndDate">

                                @error('filterEndDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <div class="d-flex gap-2">
                                    <button type="button"
                                        class="btn btn-soft-secondary waves-effect waves-light flex-grow-1"
                                        wire:click="preview">
                                        <i class="mdi mdi-filter-outline d-block font-size-16"></i> Preview
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

    @livewire('report-attendance.report-attendance-preview', key('preview'))
</div>
