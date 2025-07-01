<div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-end">
                <div class="flex-shrink-0">
                    @can('activity.create')
                        {{-- <a href="javascript:void(0);" class="btn btn-primary" wire:click="$dispatch('showForm')">Add New Activity</a> --}}
                        <a href="{{ route('activity.create') }}" class="btn btn-primary">Add New Activity</a>
                        <a href="{{route('activity.import')}}" class="btn btn-success">Import Activity</a>
                    @endcan

                    <a href="#!" class="btn btn-light" wire:click="$dispatch('refreshIndex')"><i
                            class="mdi mdi-refresh"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-lg-6">
                                <label for="searchInput">Search</label>
                                <input type="search" class="form-control" id="searchInput" wire:model="search"
                                    placeholder="Search for ...">
                            </div>
                            <div class="col-xxl-2 col-lg-6">
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
                                <label for="filterDate">Filter Date</label>
                                <input type="date" class="form-control" placeholder="Select date"
                                    wire:model="filterDate">
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

    <div class="row">
        @foreach ($activities as $activity)
            <div class="col-md-4 col-lg-3 mb-3">
                @livewire('activity.activity-item', ['activity' => $activity, 'number' => $loop->iteration], key('activity-item-' . $activity->id . time()))
            </div>
        @endforeach

        <div class="col-lg-12">
            {{ $activities->links() }}
        </div>
    </div>

    <div id="validationActivity" class="modal fade" tabindex="-1" aria-labelledby="validationActivityLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validationActivityLabel">Validation Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate wire:submit.prevent="submitValidation">
                        <div class="mb-3">
                            <label for="status_id" class="form-label">Status</label>
                            <div class="d-flex flex-wrap gap-2 justify-content-between">
                                @foreach ($statuses as $status)
                                    <div class="col">
                                        <input type="radio" class="btn-check" name="status_id"
                                            id="status_id{{ $status->id }}" autocomplete="off" wire:model="status_id"
                                            value="{{ $status->id }}">
                                        <label class="btn btn-outline-{{ str_replace('bg-', '', $status->bg_color) }} w-100"
                                            for="status_id{{ $status->id }}">{{ $status->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn  btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="updateActualDate" class="modal fade" tabindex="-1" aria-labelledby="updateActualDateLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateActualDateLabel">Update Actual Date Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate wire:submit.prevent="submitActualDate">
                        <div class="mb-3">
                            <label for="actual_date" class="form-label">Actual Date</label>
                            <input type="date" class="form-control" wire:model="actual_date">
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn  btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @livewire('activity.activity-update-progress')

    @push('styles')
        <style>
            input[type=range] {
                -webkit-appearance: none;
                margin: 20px 0;
                width: 100%;
            }

            input[type=range]:focus {
                outline: none;
            }

            input[type=range]::-webkit-slider-runnable-track {
                width: 100%;
                height: 4px;
                cursor: pointer;
                animate: 0.2s;
                background: #03a9f4;
                border-radius: 25px;
            }

            input[type=range]::-webkit-slider-thumb {
                height: 20px;
                width: 20px;
                border-radius: 50%;
                background: #fff;
                box-shadow: 0 0 4px 0 rgba(0, 0, 0, 1);
                cursor: pointer;
                -webkit-appearance: none;
                margin-top: -8px;
            }

            input[type=range]:focus::-webkit-slider-runnable-track {
                background: #03a9f4;
            }

            .range-wrap {
                width: 100%;
                position: relative;
            }

            .range-value {
                position: absolute;
                top: -50%;
            }

            .range-value span {
                width: 30px;
                height: 24px;
                line-height: 24px;
                text-align: center;
                background: #03a9f4;
                color: #fff;
                font-size: 12px;
                display: block;
                position: absolute;
                left: 50%;
                transform: translate(-50%, 0);
                border-radius: 6px;
            }

            .range-value span:before {
                content: "";
                position: absolute;
                width: 0;
                height: 0;
                border-top: 10px solid #03a9f4;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
                top: 100%;
                left: 50%;
                margin-left: -5px;
                margin-top: -1px;
            }
        </style>
    @endpush

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {

                Livewire.on('showFormValidation', () => {
                    $('#validationActivity').modal('show');
                });

                Livewire.on('hideFormValidation', () => {
                    $('#validationActivity').modal('hide');
                });

                Livewire.on('showFormActualDate', () => {
                    $('#updateActualDate').modal('show');
                });

                Livewire.on('hideFormActualDate', () => {
                    $('#updateActualDate').modal('hide');
                });
            })
        </script>
    @endpush
</div>
