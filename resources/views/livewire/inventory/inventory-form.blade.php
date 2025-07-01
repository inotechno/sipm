<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/inventory'], ['name' => 'Inventory', 'url' => route('inventory.inventory')], ['name' => 'Inventory Create', 'url' => route('inventory.inventory.create')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0);" wire:submit.prevent="addItem" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Name <small class="text-danger"> * required</small></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    wire:model="name" id="formrow-firstname-input" placeholder="Enter Inventory Name"
                                    autocomplete="off" value="{{ old('name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Serial Number</label>
                                <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                                    wire:model="serial_number" id="formrow-firstname-input"
                                    placeholder="Enter Serial Number" autocomplete="off" value="{{ old('serial_number') }}">

                                @error('serial_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Category <small class="text-danger"> * required</small></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" wire:model="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Warehouse <small class="text-danger"> * required</small></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" wire:model="warehouse_id">
                                    <option value="">Select Warehouse</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>

                                @error('warehouse_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-1 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Stock <small class="text-danger"> * required</small></label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                    wire:model="stock" id="formrow-firstname-input" placeholder="Enter Stock"
                                    autocomplete="off" value="{{ old('stock') }}">

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-1 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Unit <small class="text-danger"> * required</small></label>
                                <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                    wire:model="unit" id="formrow-firstname-input" placeholder="Enter Unit"
                                    autocomplete="off" value="{{ old('unit') }}">

                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    wire:model="price" id="formrow-firstname-input" placeholder="Enter Price"
                                    autocomplete="off" value="{{ old('price') }}">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Condition</label>
                                <select name="condition" id="" class="form-select" wire:model="condition">
                                    <option value="">Select Condition</option>
                                    <option value="New">New</option>
                                    <option value="Used">Used</option>
                                    <option value="Broken">Broken</option>
                                </select>

                                @error('condition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Purchase Date</label>
                                <input type="date" class="form-control @error('purchase_date') is-invalid @enderror"
                                    wire:model="purchase_date" id="formrow-firstname-input"
                                    placeholder="Enter Purchase Date" autocomplete="off"
                                    value="{{ old('purchase_date') }}">

                                @error('purchase_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Type</label>
                                <select name="type" id="" class="form-select" wire:model="type">
                                    <option value="">Select Type</option>
                                    <option value="Asset">Asset</option>
                                    <option value="Consumable">Consumable</option>
                                    <option value="Service">Service</option>
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="formrow-firstname-input" class="form-label">Description</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                    wire:model="description" id="formrow-firstname-input"
                                    placeholder="Enter Description" autocomplete="off"
                                    value="{{ old('description') }}">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (count($items) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Items</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Warehouse</th>
                                        <th>Serial Number</th>
                                        <th>Purchase Date</th>
                                        <th>Stock Unit</th>
                                        <th>Condition</th>
                                        <th>Price</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['category_name'] }}</td>
                                            <td>{{ $item['warehouse_name'] }}</td>
                                            <td>{{ $item['serial_number'] }}</td>
                                            <td>{{ $item['purchase_date'] }}</td>
                                            <td>{{ $item['stock'] }} {{ $item['unit'] }}</td>
                                            <td>{{ $item['condition'] }}</td>
                                            <td>{{ $item['price'] }}</td>
                                            <td>{{ $item['type'] }}</td>
                                            <td>{{ $item['description'] }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" wire:click="editItem({{ $index }})"><i class="mdi mdi-pencil"></i></button>
                                                <button class="btn btn-danger btn-sm" wire:click="removeItem({{ $index }})"><i class="mdi mdi-delete"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button class="btn btn-success" wire:click="submit">Submit All</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
