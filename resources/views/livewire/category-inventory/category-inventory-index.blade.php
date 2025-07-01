<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/inventory'], ['name' => 'Category Inventory', 'url' => route('inventory.category')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('category-inventory.category-inventory-list')
        </div>

        <div class="col-lg-4">
            @livewire('category-inventory.category-inventory-form', key('category-inventory-form'))
        </div>
    </div>

</div>
