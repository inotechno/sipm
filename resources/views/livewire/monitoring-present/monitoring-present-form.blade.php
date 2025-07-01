<div>
    <div id="addMonitoringPresent" class="modal fade" tabindex="-1" aria-labelledby="addMonitoringPresentLabel"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMonitoringPresentLabel">Add Monitoring Present</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" wire:submit.prevent="submitMonitoringPresent">

                        {{-- <div class="form-floating mb-3">
                            <input type="date" class="form-control @error('shift_date') is-invalid @enderror"
                                id="shift_date" wire:model.live="shift_date">
                            <label for="search">Select Shift Date * Pilih Tanggal Awal Masuk Kerja Shift</label>

                            @error('group_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        <div class="form-floating mb-3" wire:loading wire:target="shift_date">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3" wire:loading.remove wire:target="shift_date">
                            <select class="form-select @error('group_id') is-invalid @enderror"
                                @if (!$shift_date) disabled @endif id="group_id"
                                wire:model.live="group_id">
                                <option selected value="">-- Select Group --</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }} |
                                        {{ $group->supervisor->name }}</option>
                                @endforeach
                            </select>

                            <label for="search">Select Group</label>

                            @error('group_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3" wire:loading.remove wire:target="shift_date">
                            <select class="form-select @error('shift_id') is-invalid @enderror"
                                @if (!$shift_date) disabled @endif id="shift_id"
                                wire:model.live="shift_id">
                                <option selected value="">-- Select Shift --</option>
                                @foreach ($shiftForms as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }}
                                        {{ \Carbon\Carbon::parse($shift->day_of_week)->translatedFormat('l') }}</option>
                                @endforeach
                            </select>

                            <label for="shift_id">Select Shift</label>

                            @error('shift_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @if($shift_id == $shift_2)
                                <span class="text-danger">Pengisian data maksimal jam 6 pagi, untuk mengatasi bentrok tanggal karena perpindahan hari.</span>
                            @endif
                        </div>

                        <div class="form-floating mb-3" wire:loading.remove wire:target="shift_date">
                            <select class="form-select @error('type') is-invalid @enderror"
                                @if (!$shift_date) disabled @endif wire:loading.attr="disabled"
                                wire:target="shift_id" id="type" wire:model="type">
                                <option selected value="">-- Select Time --</option>
                                @role('Supervisor')
                                    @if ($shift_id == $shift_1)
                                        <option value="07">07:00</option>
                                        <option value="09">09:00</option>
                                        <option value="15">15:00</option>
                                        <option value="17">17:00</option>
                                    @else
                                        <option value="19">19:00</option>
                                        <option value="21">21:00</option>
                                        <option value="03">03:00</option>
                                        <option value="05">05:00</option>
                                    @endif
                                @else
                                    @if ($shift_id == $shift_1)
                                        <option value="08">08:00</option>
                                        <option value="10">10:00</option>
                                        <option value="14">14:00</option>
                                        <option value="16">16:00</option>
                                        <option value="18">18:00</option>
                                    @else
                                        <option value="20">20:00</option>
                                        <option value="22">22:00</option>
                                        <option value="02">02:00</option>
                                        <option value="04">04:00</option>
                                        <option value="06">06:00</option>
                                    @endif
                                @endrole
                            </select>
                            <label for="type">Select Time</label>

                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="search" wire:model.live="search">
                            <label for="search">Search Name, ID</label>
                        </div>


                        <div class="form-floating mb-3" wire:loading>
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        @isset($group_id)
                        <div style="height: 600px; overflow-y: scroll" class="table-responsive" wire:loading.remove>
                            <table class="table table-bordered align-middle table-wrap table-sm">
                                <thead>
                                    <th width="20%">Employee Name</th>
                                    <th width="10%">Is Present</th>
                                    <th width="30%">Reason</th>
                                    <th>Notes</th>
                                </thead>
                                <tbody class="">
                                    <tr class="table-warning">
                                        <td>Select All</td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                wire:click="selectAll" type="button">
                                                @if (!$select_all)
                                                    Select All
                                                @else
                                                    Unselect All
                                                @endif
                                            </button>
                                        </td>
                                    </tr>
                                    @empty(!$employees)
                                        @foreach ($employees as $employee)
                                            <tr class="align-middle">
                                                <td>{{ $employee->id }} | {{ $employee->name }} |
                                                    {{ $employee->group?->name }}</td>
                                                <td class="square-switch text-center">
                                                    <input type="checkbox"
                                                        class="is_presents @error('is_presents.{{ $employee->id }}') is-invalid @enderror"
                                                        id="is_presents_{{ $employee->id }}" switch="none"
                                                        wire:model.live="is_presents.{{ $employee->id }}" value="1">
                                                    <label for="is_presents_{{ $employee->id }}" data-on-label="Yes"
                                                        data-off-label="No"></label>

                                                    @error('is_presents.{{ $employee->id }}')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex align-items-center gap-2 flex-wrap justify-content-between">
                                                        <select
                                                            class="form-select @error('reasons.{{ $employee->id }}') is-invalid @enderror w-auto"
                                                            id="reason_{{ $employee->id }}"
                                                            wire:model.live="reasons.{{ $employee->id }}">
                                                            <option value="">-- Select Reason --</option>
                                                            <option value="sakit">Sakit</option>
                                                            <option value="tanpa_keterangan">Tanpa Keterangan</option>
                                                            <option value="cuti">Cuti</option>
                                                            <option value="training">Training</option>
                                                            <option value="pindah_supervisor">Pindah Supervisor</option>
                                                        </select>

                                                        @error('reasons.{{ $employee->id }}')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror


                                                        <select
                                                            class="form-select @error('move_supervisors.{{ $employee->id }}') is-invalid @enderror"
                                                            id="move_supervisors_{{ $employee->id }}"
                                                            @if (isset($is_presents[$employee->id]) && $reasons[$employee->id] == 'pindah_supervisor') style="display: block"
                                                            @else style="display: none" @endif
                                                            wire:model.live="move_supervisors.{{ $employee->id }}">
                                                            <option value="">-- Select Supervisor --</option>
                                                            @foreach ($supervisors as $supervisor)
                                                                <option value="{{ $supervisor->id }}">
                                                                    {{ $supervisor->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('move_supervisors.{{ $employee->id }}')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        class="form-control @error('notes.{{ $employee->id }}') is-invalid @enderror w-auto"
                                                        placeholder="Catatan"
                                                        {{ isset($is_presents[$employee->id]) && $is_presents[$employee->id] ? 'disabled' : '' }}
                                                        wire:model.live="notes.{{ $employee->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endempty
                                </tbody>
                            </table>
                        </div>
                        @endisset

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

                Livewire.on('showModalAddMonitoring', () => {
                    $('#addMonitoringPresent').modal('show');
                });

                Livewire.on('hideModalAddMonitoring', () => {
                    $('#addMonitoringPresent').modal('hide');
                });

            })
        </script>
    @endpush
</div>
