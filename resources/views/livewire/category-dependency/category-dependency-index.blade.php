<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Category Dependency', 'url' => route('master.category-dependencies')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('category-dependency.category-dependency-list')
        </div>

        <div class="col-lg-4">
            @livewire('category-dependency.category-dependency-form', key('category-dependency-form'))
        </div>
    </div>

</div>
