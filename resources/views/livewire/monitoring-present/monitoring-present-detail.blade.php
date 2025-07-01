<div>
    <div id="detailPresent" class="modal fade" tabindex="-1" aria-labelledby="detailPresentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPresentLabel">Detail Present</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless table-striped align-middle">
                        <thead>
                            <th width="50%">Employee Name</th>
                            <th>Is Present</th>
                            <th>Note/Reason</th>
                        </thead>
                        <tbody>
                            @empty(!$details)
                                @foreach ($details as $detail)
                                    <tr class="align-middle">
                                        <td>{{ $detail->employee->id }} | {{ $detail->employee->name }}</td>
                                        <td class="square-switch">
                                            <input type="checkbox" id="is_present_{{ $detail->id }}" switch="none"
                                                wire:model="is_present.{{ $detail->id }}" value="1"
                                                {{ $detail->is_present == 1 ? 'checked' : '' }} disabled readonly>
                                            <label for="is_present_{{ $detail->id }}" data-on-label="Yes"
                                                data-off-label="No"></label>
                                        </td>
                                        <td>
                                            Reason: {{ strtoupper(str_replace('_', ' ', $detail->reason)) }}
                                            {{ $detail->reason == 'pindah_supervisor' ? ' (' . $detail->moveSupervisor?->name . ')' : '' }}
                                            <br> Note: {{ $detail->note != '' ? $detail->note : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endempty
                        </tbody>
                    </table>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn  btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {

                Livewire.on('showModalDetails', () => {
                    $('#detailPresent').modal('show');
                });

                Livewire.on('hideModalDetails', () => {
                    $('#detailPresent').modal('hide');
                });
            })
        </script>
    @endpush
</div>
