<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Report Activity Progress', 'url' => route('activity.report.progress')]]], key('breadcrumb'))

    <div class="row">

        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-lg-4">
                                @livewire(
                                    'component.form.select2',
                                    [
                                        'label' => 'Filter Scope',
                                        'model' => 'filterScope',
                                        'options' => $scopes->map(fn($e) => ['value' => $e->id, 'text' => $e->name])->toArray(),
                                        'selected' => $filterScope,
                                        'placeholder' => '-- Select Scope --',
                                        'multiple' => true,
                                    ],
                                    key('filterScope')
                                )
                            </div>
                            <div class="col-xxl-1 col-lg-4">
                                @livewire(
                                    'component.form.select2',
                                    [
                                        'label' => 'Filter Area',
                                        'model' => 'filterArea',
                                        'options' => $areas->map(fn($e) => ['value' => $e->id, 'text' => $e->name])->toArray(),
                                        'selected' => $filterArea,
                                        'placeholder' => '-- Select Area --',
                                        'multiple' => true,
                                    ],
                                    key('filterArea')
                                )
                            </div>
                            <div class="col-xxl-1 col-lg-4">
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
                                @livewire(
                                    'component.form.select2',
                                    [
                                        'label' => 'Filter Supervisor',
                                        'model' => 'filterSupervisor',
                                        'options' => $supervisors->map(fn($e) => ['value' => $e->id, 'text' => $e->name])->toArray(),
                                        'selected' => $filterSupervisor,
                                        'placeholder' => '-- Select Supervisor --',
                                        'multiple' => true,
                                    ],
                                    key('filterSupervisor')
                                )
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <label for="filterStartDate">Filter Start Date</label>
                                <input type="date" class="form-control @error('filterStartDate') is-invalid @enderror" id="filterStartDate"
                                    wire:model="filterStartDate">

                                @error('filterStartDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <label for="filterEndDate">Filter End Date</label>
                                <input type="date" class="form-control @error('filterEndDate') is-invalid @enderror" id="filterEndDate"
                                    wire:model="filterEndDate">

                                @error('filterEndDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xxl-2 col-lg-4 d-flex gap-2 align-items-center justify-content-center">
                                <button type="button"
                                    class="btn btn-soft-secondary waves-effect waves-light flex-grow-1"
                                    wire:click="filter">
                                    <i class="mdi mdi-filter-outline d-block font-size-16"></i> Filter
                                </button>
                                <button type="button" class="btn btn-soft-danger waves-effect waves-light flex-grow-1"
                                    wire:click="resetFilter">
                                    <i class="mdi mdi-refresh d-block font-size-16"></i> Reset
                                </button>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
        </div>

    </div>

    @if (count($progresses) > 0)
        @livewire('report.progress.report-progress-preview', ['progresses' => $progresses], key('report-progress-preview' . time()))
    @endif

</div>
