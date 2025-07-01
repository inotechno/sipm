<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Employee', 'url' => route('master.employees')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('employee.employee-list', key('employee-list'))
        </div>

        @can('employee.create')
            <div class="col-lg-3">
                @livewire('employee.employee-form', key('employee-form'))
                @livewire('employee.employee-import', key('employee-import'))
            </div>
        @endcan
    </div>

</div>
