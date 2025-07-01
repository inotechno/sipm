<div>
    <div id="addFolder" class="modal fade" tabindex="-1" aria-labelledby="addFolderLabel" data-bs-backdrop="static"
        data-bs-keyboard="false" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFolderLabel">Add Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" wire:submit.prevent="submitAddFolder">

                        <div class="row">
                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="color" placeholder="Enter Code"
                                        wire:model="color">
                                    <label for="color">Color</label>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="icon" placeholder="Enter Icon"
                                        wire:model="icon">
                                    <label for="icon">Icon</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" wire:model="name">
                            <label for="name">Name</label>
                        </div>

                        <div class="mb-3">
                            <label for="roles">Roles</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($roles as $role)
                                    <div class="form-check form-checkbox-outline form-check-primary">
                                        <input class="form-check-input" type="checkbox"
                                            id="{{ Str::slug($role->name) }}" wire:model="selectedRoles" value="{{ $role->name }}">
                                        <label class="form-check-label" for="{{ Str::slug($role->name) }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="button" class="btn  btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {

                Livewire.on('showModalAddFolder', () => {
                    $('#addFolder').modal('show');
                });

                Livewire.on('hideModalAddFolder', () => {
                    $('#addFolder').modal('hide');
                });

            })
        </script>
    @endpush
</div>
