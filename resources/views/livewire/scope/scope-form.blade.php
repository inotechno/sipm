<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">{{$mode == 'create' ? 'Create Scope' : 'Edit Scope ' . $name }}</h4>

            <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="formrow-firstname-input" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" id="formrow-firstname-input"
                        placeholder="Enter Scope Name" autocomplete="off" value="{{ old('name') }}">

                    @error('name')
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
