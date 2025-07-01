<div>
    <div class="offcanvas-header">
        <h5 id="offcanvasBottomLabel">{{ $mode == 'create' ? 'Create Activity' : 'Edit Activity ' . $name }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form wire:submit.prevent="submit" class="needs-validation" novalidate wire:ignore>
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

            <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="formrow-groups" class="form-label">Group</label>
                        <select class="form-control @error('group_id') is-invalid @enderror" wire:model="group_id"
                            data-placeholder="Choose ...">
                            <option value="">-- Select Group --</option>
                            @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>

                        @error('group_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
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
                        <label for="formrow-inputState" class="form-label">Estimation</label>
                        <input type="number" class="form-control @error('total_estimate') is-invalid @enderror"
                            wire:model="total_estimate" id="formrow-inputState" min="1">

                        @error('total_estimate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="formrow-forecast_date-input" class="form-label">Forecast Date</label>
                <input type="date" class="form-control @error('forecast_date') is-invalid @enderror"
                    wire:model="forecast_date" id="formrow-forecast_date-input" placeholder="Enter Activity Date"
                    autocomplete="off">

                @error('forecast_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="formrow-plan_date-input" class="form-label">Plan Date</label>
                <input type="date" class="form-control @error('plan_date') is-invalid @enderror"
                    wire:model="plan_date" id="formrow-plan_date-input" placeholder="Enter Activity Date"
                    autocomplete="off">

                @error('plan_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="formrow-actual_date-input" class="form-label">Actual Date</label>
                <input type="date" class="form-control @error('actual_date') is-invalid @enderror"
                    wire:model="actual_date" id="formrow-actual_date-input" placeholder="Enter Activity Date"
                    autocomplete="off">

                @error('actual_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="formrow-inputState" class="form-label">Supervisor</label>
                <select name="supervisor_id" wire:model="supervisor_id"
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
                <label for="formrow-scopes" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" cols="30" wire:model="description"
                    rows="10"></textarea>

                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary w-md">Submit</button>
                <button type="reset" class="btn btn-secondary w-md" wire:click="resetForm"> Reset</button>
            </div>
        </form>

    </div>

    @push('styles')
    <style>
        .offcanvas-scrollable {
            max-height: 100%;
            overflow-y: auto;
        }
    </style>
    @endpush

    @push('js')
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('showForm', () => {
                const offcanvasElement = document.getElementById('addActivityCanvas');

                // Pastikan Offcanvas Bootstrap diinisialisasi
                let bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (!bsOffcanvas) {
                    bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                }

                // window.alert('Tes');
                // Tampilkan offcanvas
                bsOffcanvas.show();
            });

            Livewire.on('hideForm', () => {
                const offcanvasElement = document.getElementById('addActivityCanvas');

                // Pastikan Offcanvas Bootstrap diinisialisasi
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (bsOffcanvas) {
                    bsOffcanvas.hide();
                }
            });

        });
    </script>
    @endpush
</div>