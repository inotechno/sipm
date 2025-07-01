<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Inventory Import', 'url' => route('activity.import')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title ">Import Inventory</h4>
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
                            <option value="category">Category</option>
                            <option value="warehouse">Warehouse</option>
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
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Warehouse</th>
                                            <th>Serial Number</th>
                                            <th>Purchase Date</th>
                                            <th>Condition</th>
                                            <th>Unit</th>
                                            <th>Stock</th>
                                            <th>Price</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr>
                                                <td>{{ $row['name'] }}</td>
                                                <td>{{ $row['category_name'] }}</td>
                                                <td>{{ $row['warehouse_name'] }}</td>
                                                <td>{{ $row['serial_number'] }}</td>
                                                <td>{{ $row['purchase_date'] }}</td>
                                                <td>{{ $row['condition'] }}</td>
                                                <td>{{ $row['unit'] }}</td>
                                                <td>{{ $row['stock'] }}</td>
                                                <td>{{ $row['price'] }}</td>
                                                <td>{{ $row['type'] }}</td>
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
