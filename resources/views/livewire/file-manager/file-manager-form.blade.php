<div>
    <div id="addFile" class="modal fade" tabindex="-1" aria-labelledby="addFileLabel" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileLabel">Add File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" wire:submit.prevent="submitAddFile">

                        <div class="mb-3">
                            <label for="">File Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Enter File Name" wire:model="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            @livewire(
                                'component.form.select2',
                                [
                                    'label' => 'Select Folder',
                                    'model' => 'selectCategory',
                                    'options' => $categories->map(fn($e) => ['value' => $e->id, 'text' => $e->name])->toArray(),
                                    'selected' => $selectCategory,
                                    'placeholder' => '-- Select Folder --',
                                    'dropdownParent' => '#addFile',
                                    'multiple' => false,
                                ],
                                key('selectCategory')
                            )

                            @error('selectCategory')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                id="file" wire:model="file">

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="button" class="btn  btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                wire:loading.class="disabled">Save</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {

                Livewire.on('showModalAddFile', () => {
                    $('#addFile').modal('show');
                });

                Livewire.on('hideModalAddFile', () => {
                    $('#addFile').modal('hide');
                });

            })
        </script>
    @endpush
</div>
