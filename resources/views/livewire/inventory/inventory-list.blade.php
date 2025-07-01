<div>

    <div class="row mb-3">
        <div class="col-xl-4 col-sm-6">
            <div class="mt-2">
                <h5>INVENTORIES</h5>
            </div>
        </div>
        <div class="col-lg-8 col-sm-6">
            <form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                <div class="search-box me-2">
                    <div class="position-relative">
                        <input type="text" class="form-control border-0" placeholder="Search..." wire:model.live.delay="search">
                        <i class="bx bx-search-alt search-icon"></i>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-6">
                            <h5 class="card-title">Inventory</h5>
                        </div>
                        <div class="col-6">
                            <div class="float-end">
                                @can('inventory.create')
                                    <a href="{{ route('inventory.inventory.create') }}"
                                        class="btn btn-primary waves-effect waves-light">Add New</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">SN</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Warehouse</th>
                                    <th scope="col">Condition</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Purchase Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    @livewire('inventory.inventory-item', ['inventory' => $inventory], key($inventory->id))
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            {{ $inventories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
