<div>

    <div id="scheduleEdit" class="modal fade" tabindex="-1" aria-labelledby="scheduleEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleEditLabel">Edit Schedule </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate wire:submit.prevent="updateShift">
                        <div class="mb-3">
                            <label for="dateSchedule" class="form-label">Date</label>
                            <input type="date" class="form-control @error('dateSchedule') is-invalid @enderror" id="dateSchedule"
                                wire:model="dateSchedule" placeholder="Enter Date" autocomplete="off" value="{{ old('dateSchedule') }}" readonly disabled>
                            @error('dateSchedule')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shift_id" class="form-label">Shift</label>
                            <select name="shift_id" id="" wire:model="shift_id" class="form-control">
                                <option value="">-- Select Shift --</option>
                                @forelse ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }} {{ $shift->day_of_week }}
                                    </option>
                                @empty
                                    <option value="">No Shift</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
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

                Livewire.on('open-modal-edit-shift', () => {
                    $('#scheduleEdit').modal('show');
                })

                Livewire.on('close-modal-edit-shift', () => {
                    $('#scheduleEdit').modal('hide');
                })
            })
        </script>
    @endpush
</div>
