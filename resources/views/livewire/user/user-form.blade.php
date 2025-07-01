<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">{{ $mode == 'create' ? 'Create User' : 'Edit User ' . $name }}</h4>

            <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="formrow-firstname-input" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                        id="formrow-firstname-input" placeholder="Enter User Name" autocomplete="off"
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
                                id="formrow-email-input" wire:model="email" placeholder="Enter User Email ID"
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
                            <label for="formrow-password-input" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="formrow-password-input" wire:model="password" placeholder="Enter User Password"
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    @livewire(
                        'component.form.select2',
                        [
                            'label' => 'Select Roles',
                            'model' => 'selectedRoles',
                            'options' => $roles->map(fn($e) => ['value' => $e->name, 'text' => $e->name])->toArray(),
                            'selected' => $selectedRoles,
                            'placeholder' => '-- Select Roles --',
                            'multiple' => true,
                        ],
                        key('selectedRoles')
                    )

                    @error('selectedRoles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="mb-3">
                    @livewire(
                        'component.form.select2',
                        [
                            'label' => 'Select Permissions',
                            'model' => 'selectedPermissions',
                            'options' => $permissions->map(fn($e) => ['value' => $e->name, 'text' => $e->name])->toArray(),
                            'selected' => $selectedPermissions,
                            'placeholder' => '-- Select Permissions --',
                            'multiple' => true,
                        ],
                        key('selectedPermissions')
                    )

                    @error('selectedPermissions')
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
