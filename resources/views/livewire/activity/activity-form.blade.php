<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Activity Create', 'url' => route('activity.create')]]], key('breadcrumb'))

    <form wire:submit.prevent="submit" class="needs-validation" novalidate wire:ignore.self>
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            {{ $mode == 'create' ? 'Create Activity' : 'Edit Activity ' }}
                        </h4>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-scopes" class="form-label">Scope</label>
                                    <select class="form-control @error('scope_id') is-invalid @enderror"
                                        wire:model="scope_id" data-placeholder="Choose ...">
                                        <option value="">-- Select Scope --</option>
                                        @foreach ($scopes as $scope)
                                            <option value="{{ $scope->id }}">{{ $scope->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('scope_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-areas" class="form-label">Area</label>
                                    <select class="form-control @error('area_id') is-invalid @enderror"
                                        wire:model="area_id" data-placeholder="Choose ...">
                                        <option value="">-- Select Area --</option>
                                        @foreach ($areas as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('area_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-positions" class="form-label">Position</label>
                                    <select class="form-control @error('position_id') is-invalid @enderror"
                                        wire:model="position_id" data-placeholder="Choose ...">
                                        <option value="">-- Select Position --</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('position_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">Quantity</label>
                                    <input type="number" class="form-control @error('total_quantity') is-invalid @enderror"
                                        wire:model="total_quantity" id="formrow-inputState" min="1">

                                    @error('total_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">Estimation</label>

                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control @error('total_estimate') is-invalid @enderror"
                                            wire:model="total_estimate" id="formrow-inputState" min="1">
                                        <label class="input-group-text">Day</label>
                                    </div>

                                    @error('total_estimate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-forecast_date-input" class="form-label">Forecast Date</label>
                                    <input type="date"
                                        class="form-control @error('forecast_date') is-invalid @enderror"
                                        wire:model="forecast_date" id="formrow-forecast_date-input"
                                        placeholder="Enter Activity Date" autocomplete="off">

                                    @error('forecast_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">

                                <div class="mb-3">
                                    <label for="formrow-plan_date-input" class="form-label">Plan Date</label>
                                    <input type="date" class="form-control @error('plan_date') is-invalid @enderror"
                                        wire:model="plan_date" id="formrow-plan_date-input"
                                        placeholder="Enter Activity Date" autocomplete="off">

                                    @error('plan_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="formrow-scopes" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" wire:model="description"
                                rows="10"></textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if (!empty($selectedEmployees))
                            <div class="mb-3">
                                <label class="form-label">Selected Employees</label>
                                <div class="d-flex flex-wrap">
                                    @foreach (array_values($selectedEmployees) as $selectedEmployee)
                                        <div
                                            class="px-3 py-2 rounded bg-light bg-opacity-50 d-block mb-2 me-2 align-middle">
                                            <span class="badge bg-primary">{{ $selectedEmployee['id'] }}</span>
                                            {{ $selectedEmployee['name'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Select Employees & Supervisor</h4>
                        <div class="mb-3">
                            <label for="formrow-inputState" class="form-label">Supervisor</label>
                            <select name="supervisor_id" wire:model.live="supervisor_id"
                                class="form-control @error('type') is-invalid @enderror" id="">
                                <option value="">-- Select Supervisor --</option>
                                @foreach ($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>

                            @error('supervisor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            @livewire('component.form.employee-table', key('employee-table'))
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" wire:submit.prevent="submit"
                                class="btn btn-primary w-md">Submit</button>
                            @if($mode == 'edit')
                                <button type="button" class="btn btn-warning w-md" wire:click="changeNewPlan">Change New
                                Plan</button>
                            @endif
                            <button type="button" class="btn btn-secondary w-md"
                                wire:click="resetForm">Reset</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </form>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .select2-container--bootstrap-5 .select2-selection--multiple {
                border-radius: 0.375rem;
                padding: 0.375rem 1.25rem;
            }

            .select2-container--bootstrap-5 .select2-selection__rendered {
                padding-left: 0.75rem;
            }
        </style>
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                let selectElement = $('.select2-multiple');

                selectElement.select2({
                    width: '100%',
                    placeholder: "Choose ...",
                    allowClear: true
                }).on('change', function() {
                    let selectedValues = $(this).val();
                    Livewire.dispatch('change-input-form', ['selectedEmployees', selectedValues]);
                });

                Livewire.on('set-default-form', () => {
                    var selectedEmployees = @json($selectedEmployees);
                    selectElement.val(selectedEmployees).trigger('change');
                })
            })
        </script>
    @endpush
</div>
