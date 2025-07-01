<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Group', 'url' => route('master.groups')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('group.group-list')
        </div>

        @can('group.create')
            <div class="col-lg-3">
                @livewire('group.group-form', key('group-form'))
            </div>
        @endcan
    </div>

    @can('group.edit')
        @livewire('group.employee-added-group', key('employee-added-group'))
    @endcan
</div>
