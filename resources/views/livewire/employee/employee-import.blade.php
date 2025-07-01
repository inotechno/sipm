<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <h4 class="card-title ">Import Employee</h4>
                <a href="javascript: void(0);" class="ms-auto flex-shrink-0" wire:click="downloadTemplate">Download Template</a>
            </div>

            <form wire:submit.prevent="import" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="formrow-file-input" class="form-label">File</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" wire:model="file" id="formrow-file-input"
                        placeholder="Enter File" autocomplete="off">

                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-md" wire:loading.attr="disabled" wire:target="file">Submit</button>
                    <button type="reset" class="btn btn-secondary w-md" wire:click="resetForm"> Reset</button>
                </div>
            </form>
        </div>
        <!-- end card body -->
    </div>

</div>
