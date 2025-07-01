<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Role', 'url' => route('master.roles')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('role.role-list')
        </div>

        <div class="col-lg-4">
            @livewire('role.role-form', key('role-form'))
        </div>
    </div>

    @livewire('role.permission-added-role', key('permission-added-role'))

</div>
