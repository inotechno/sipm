<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">{{ $mode == 'create' ? 'Create Group' : 'Edit Group ' . $name }}</h4>

            <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="formrow-firstname-input" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                        id="formrow-firstname-input" placeholder="Enter Group Name" autocomplete="off"
                        value="{{ old('name') }}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formrow-supervisor-input" class="form-label">Supervisor</label>
                    <select name="supervisor_id" wire:model="supervisor_id"
                        class="form-control @error('supervisor_id') is-invalid @enderror" id="">
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
                <div class="d-flex gap-2 align-items-center">
                    <button type="submit" class="btn btn-primary w-sm">Submit</button>
                    <button type="reset" class="btn btn-secondary w-sm" wire:click="resetForm"> Reset</button>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>

</div>
