<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Position', 'url' => route('master.positions')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('position.position-list')
        </div>

        <div class="col-lg-4">
            @livewire('position.position-form', key('position-form'))
        </div>
    </div>

    @livewire('position.employee-added-position', key('employee-added-position'))

</div>
