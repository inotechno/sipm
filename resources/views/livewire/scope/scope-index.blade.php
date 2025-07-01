<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Scope', 'url' => route('master.scopes')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('scope.scope-list')
        </div>

        <div class="col-lg-4">
            @livewire('scope.scope-form', key('scope-form'))
        </div>
    </div>

</div>
