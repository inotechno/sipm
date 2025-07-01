<div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">{{ $mode == 'create' ? 'Create Employee' : 'Edit Employee ' . $name }}</h4>

            <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="formrow-employee-id-input" class="form-label">Employee ID</label>
                    <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                        wire:model="employee_id" id="formrow-employee-id-input" placeholder="Enter Employee ID"
                        autocomplete="off" value="{{ old('employee_id') }}">

                    @error('employee_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formrow-firstname-input" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                        id="formrow-firstname-input" placeholder="Enter Employee Name" autocomplete="off"
                        value="{{ old('name') }}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formrow-email-input" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="formrow-email-input" wire:model="email" placeholder="Enter Employee Email ID"
                                autocomplete="off">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formrow-phone-input" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                id="formrow-phone-input" wire:model="phone" placeholder="Enter Employee Phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="formrow-shifts" class="form-label">Shift</label>
                    <select class="form-control @error('shift') is-invalid @enderror" wire:model="shift"
                        data-placeholder="Choose ...">
                        <option value="">-- Select Shift --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>

                    @error('shift')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formrow-groups" class="form-label">Group</label>
                    <select class="form-control @error('group') is-invalid @enderror" wire:model="group"
                        data-placeholder="Choose ...">
                        <option value="">-- Select Group --</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} | {{ $group->supervisor?->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('group')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="formrow-inputState" class="form-label">Position</label>
                    <select class="form-control @error('position') is-invalid @enderror" wire:model.live="position"
                        data-placeholder="Choose ...">
                        <option value="">-- Select Position --</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>

                    @error('position')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                    <button type="reset" class="btn btn-secondary w-md" wire:click="resetForm"> Reset</button>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>

</div>
