<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/inventory'], ['name' => 'Inventory', 'url' => route('inventory.inventory')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-2">
            @livewire('inventory.inventory-filter', key('inventory-filter'))
        </div>

        <div class="col-lg">
            @livewire('inventory.inventory-list', key('inventory-list'))
        </div>
    </div>
</div>
