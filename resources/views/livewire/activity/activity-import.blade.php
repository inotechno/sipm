<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Activity Import', 'url' => route('activity.import')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title ">Import Activities</h4>
                        <a href="javascript: void(0);" class="ms-auto flex-shrink-0" wire:click="downloadTemplate">Download
                            Template</a>
                    </div>

                    <form wire:submit.prevent="preview" class="needs-validation">
                        <div class="mb-3">
                            <label for="formrow-file-input" class="form-label">File</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                wire:model="file" id="formrow-file-input" placeholder="Enter File" autocomplete="off">

                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary w-md flex-grow-1" wire:loading.attr="disabled"
                                wire:target="file">Submit</button>
                            <button type="reset" class="btn btn-secondary w-md  flex-grow-1" wire:click="resetForm">
                                Reset</button>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Related Data</h4>

                    <div class="mb-3">
                        <select name="filterRelasi" id="" class="form-control form-select"
                            wire:model.live="filterRelasi">
                            <option value="">Select Related Data</option>
                            <option value="area">Area</option>
                            <option value="position">Position</option>
                            <option value="scope">Scope</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="status">Status Activity</option>
                        </select>
                    </div>

                    <div class="table-responsive" style="max-height: 300px; overflow-y: scroll;">
                        <table class="table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr wire:loading wire:target="filterRelasi">
                                    <td colspan="2" class="text-center">Loading...</td>
                                </tr>

                                @if (isset($relations))
                                    @foreach ($relations as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="2">Tidak ada data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- PREVIEW DATA -->
        @if ($readyToImport)
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title mb-3">Preview Data</h5>

                        <div wire:loading wire:target="preview">    
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <div wire:loading.remove wire:target="preview">

                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Scope</th>
                                            <th>Area</th>
                                            <th>Position</th>
                                            <th>Supervisor</th>
                                            <th>Total Estimate</th>
                                            <th>Forecast Date</th>
                                            <th>Plan Date</th>
                                            <th>Actual Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $row['scope_name'] ?? '-' }}</td>
                                                <td>{{ $row['area_name'] ?? '-' }}</td>
                                                <td>{{ $row['position_name'] ?? '-' }}</td>
                                                <td>{{ $row['supervisor_name'] ?? '-' }}</td>
                                                <td>{{ $row['total_estimate'] ?? '-' }}</td>
                                                <td>{{ $row['forecast_date'] ?? '-' }}</td>
                                                <td>{{ $row['plan_date'] ?? '-' }}</td>
                                                <td>{{ $row['actual_date'] ?? '-' }}</td>
                                                <td>{{ $row['description'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button wire:click="import" class="btn btn-success mt-3">
                                Konfirmasi & Import
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
