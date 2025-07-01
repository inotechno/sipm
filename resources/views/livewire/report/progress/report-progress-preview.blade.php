<div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-end">
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-success waves-effect btn-label waves-light"
                        wire:click="exportExcel" wire:loading.attr="disabled"><i class="fas fa-file-excel label-icon"></i>
                        Excel</button>
                    <button type="button" class="btn btn-danger waves-effect btn-label waves-light"
                        wire:click="exportPdf" wire:loading.attr="disabled"><i class="fas fa-file-pdf label-icon"></i>
                        PDF</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Preview Report Activity Progress</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="align-middle">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Scope</th>
                                    <th scope="col">Area</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Plan Date</th>
                                    <th scope="col">Forecast Date</th>
                                    <th scope="col">Estimate Time</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Quantity</th>
                                    <th scope="col">Supervisor</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach ($progresses as $progress)
                                    <tr>
                                        <td>{{ $progress['date'] }}</td>
                                        <td>{{ $progress['activity']['scope']['name'] }}</td>
                                        <td>{{ $progress['activity']['area']['name'] }}</td>
                                        <td>{{ $progress['activity']['position']['name'] }}</td>
                                        <td>{{ $progress['activity']['plan_date'] }}</td>
                                        <td>{{ $progress['activity']['forecast_date'] }}</td>
                                        <td>{{ $progress['activity']['total_estimate'] }} Day</td>
                                        <td>{{ $progress['quantity'] ?? 0 }}</td>
                                        <td>{{ $progress['activity']['total_quantity'] ?? 0 }}</td>
                                        <td>{{ $progress['activity']['supervisor']['name'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
