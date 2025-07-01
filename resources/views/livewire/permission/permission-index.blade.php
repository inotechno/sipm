<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Permission', 'url' => route('master.permissions')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('permission.permission-list')
        </div>

        <div class="col-lg-4">
            @livewire('permission.permission-form', key('permission-form'))
        </div>
    </div>
</div>
