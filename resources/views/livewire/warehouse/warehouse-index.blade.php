<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/inventory'], ['name' => 'Warehouse', 'url' => route('inventory.warehouse')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('warehouse.warehouse-list')
        </div>

        <div class="col-lg-4">
            @livewire('warehouse.warehouse-form', key('warehouse-form'))
        </div>
    </div>

</div>
