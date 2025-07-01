<div>
    <!-- sample modal content -->
    <div id="{{ $modal_id }}" class="modal fade" tabindex="-1" aria-labelledby="{{ $modal_id }}Label"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ $modal_id }}Label">
                        Attendance Status {{ $modal_title ?? '' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="filterGroup" class="form-label">Filter by Group</label>
                                <select class="form-select" id="filterGroup" wire:model.live="filterGroup">
                                    <option value="">All Groups</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }} |
                                            {{ $group->supervisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="searchName" class="form-label">Search by Name</label>
                                <input type="text" class="form-control" id="searchName" wire:model.live="searchName"
                                    placeholder="Enter employee name">
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Group</th>
                                            <th>Position</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filteredItems as $item)
                                            <tr>
                                                <td>{{ isset($item['name']) ? $item['name'] : '-' }}
                                                </td>
                                                <td>{{ isset($item['group']['name']) ? $item['group']['name'] : '-' }}
                                                </td>
                                                <td>{{ isset($item['position']['name']) ? $item['position']['name'] : '-' }}</td>
                                                <td>{{ isset($item['timestamp']) ? $item['timestamp'] : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    Total: {{ count($filteredItems) }}
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @push('styles')
        <style>
            table thead {
                position: sticky;
                top: 0;
                z-index: 1;
                background-color: #fff;
                margin: 0;
                /* Hilangkan margin */
                padding: 0;
                /* Hilangkan padding */
            }

            table tfoot {
                position: sticky;
                bottom: 0;
                z-index: 1;
                background-color: #fff;
                margin: 0;
                /* Hilangkan margin */
                padding: 0;
                /* Hilangkan padding */
            }

            .table-responsive {
                overflow-y: auto;
                /* Aktifkan scroll vertikal */
                max-height: 500px;
                /* Atur tinggi maksimum */
            }

            .table-striped {
                margin: 0;
                /* Hilangkan margin tabel */
                padding: 0;
                /* Hilangkan padding tabel */
            }

            .table-striped th,
            .table-striped td {
                border: 1px solid #dee2e6;
                /* Tambahkan border untuk konsistensi */
            }
        </style>
    @endpush
    @script
        <script>
            $wire.on('showModal', () => {
                var modal = $wire.get('modal_id');
                $('#' + modal).modal('show');
            })
        </script>
    @endscript
</div>
