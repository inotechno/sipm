<div>
    <div id="updateProgress" class="modal fade" tabindex="-1" aria-labelledby="updateProgressLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProgressLabel">Update Progress</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate wire:submit.prevent="submitProgress">

                        <table class="table table-borderless table-striped align-middle">
                            <thead>
                                <th width="80%">Date</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @empty(!$progress)
                                    @foreach ($progress as $prg)
                                        <tr>
                                            <td>{{ $prg['date'] }}</td>
                                            <td>{{ $prg['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                @endempty

                                <tr>
                                    <td>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" wire:model="date" min="{{$lastProgress}}">

                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" wire:model="quantity">

                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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

                Livewire.on('showFormProgress', () => {
                    $('#updateProgress').modal('show');
                });

                Livewire.on('hideFormProgress', () => {
                    $('#updateProgress').modal('hide');
                });
            })
        </script>
    @endpush
</div>
