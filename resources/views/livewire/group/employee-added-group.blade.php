<div>
    <div id="insertEmployeeGroup" class="modal fade" tabindex="-1" aria-labelledby="insertEmployeeGroupLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertEmployeeGroupLabel">Add Employee To Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate wire:submit.prevent="submitInsertMultiple">

                        <div class="row">
                            <div class="col-md-6">
                                {{-- Search --}}
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Search</label>
                                    <input type="text" class="form-control" wire:model.live="search"
                                        id="formrow-firstname-input" placeholder="Enter Employee Name"
                                        autocomplete="off">
                                </div>

                                <div style="height: 500px;overflow-y: scroll">
                                    <table class="table table-borderless table-sm">
                                        <tbody class="align-middle">
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td>
                                                        {{ $employee->id }} - {{ $employee->name }}
                                                    </td>

                                                    <td>
                                                        @if (in_array($employee->id, array_column($selectedEmployees, 'id')))
                                                            <button class="btn btn-secondary btn-sm" type="button"
                                                                disabled>
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-primary btn-sm"
                                                                wire:click="addEmployee({{ $employee->id }},'{{ $employee->name }}')"
                                                                type="button" wire:loading.attr="disabled">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center mt-3">
                                    <button type="button" class="btn btn-soft-primary waves-effect waves-light btn-sm"
                                        wire:click="loadMore"><i class="bx bx-hourglass bx-spin me-2"></i> Load
                                        More</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Selected Employee</label>
                                    <div style="height: 500px;overflow-y: scroll">
                                        <table class="table table-borderless table-sm">
                                            <tbody class="align-middle">
                                                @foreach ($selectedEmployees as $selected)
                                                    <tr>
                                                        <td>
                                                            {{ $selected['id'] }} - {{ $selected['name'] ?? '' }}
                                                        </td>

                                                        <td >
                                                            <button class="btn btn-danger btn-sm"
                                                                wire:click="removeEmployee({{ $selected['id'] }})"
                                                                type="button" wire:loading.attr="disabled"><i
                                                                    class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn  btn-secondary waves-effect"
                            wire:click="$dispatch('close-form-add-group')">Close</button>
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
                Livewire.on('open-modal-add-group', () => {
                    $('#insertEmployeeGroup').modal('show');
                });

                Livewire.on('close-modal-add-group', () => {
                    $('#insertEmployeeGroup').modal('hide');
                });
            })
        </script>
    @endpush
</div>
