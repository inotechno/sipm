<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Update Profile</h4>

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

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formrow-password-input" class="form-label">Password</label>
                            <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                <input type="{{ $passwordShow ? 'text' : 'password' }}"
                                    class="form-control @error('password') is-invalid @enderror" wire:model="password"
                                    placeholder="Enter password" aria-label="Password"
                                    aria-describedby="password-addon">
                                <button class="btn btn-light " type="button" wire:click="togglePassword"><i
                                        class="mdi mdi-eye-outline"></i></button>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formrow-password-input" class="form-label">Confirm Password</label>

                            <div
                                class="input-group auth-pass-inputgroup @error('password_confirm') is-invalid @enderror">
                                <input type="{{ $passwordConfirmShow ? 'text' : 'password' }}"
                                    class="form-control @error('password_confirm') is-invalid @enderror"
                                    wire:model="password_confirm" placeholder="Enter password" aria-label="Password">
                                <button class="btn btn-light" type="button" wire:click="togglePasswordConfirm"><i
                                        class="mdi mdi-eye-outline"></i></button>
                            </div>

                            @error('password_confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <em class="text-info">Kosongkan jika tidak ingin mengganti password</em>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-stretch">
                    <button type="submit" class="btn btn-primary w-md flex-grow-1">Submit</button>
                    <button type="reset" class="btn btn-secondary w-md flex-grow-1" wire:click="resetForm">
                        Reset</button>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>

</div>
