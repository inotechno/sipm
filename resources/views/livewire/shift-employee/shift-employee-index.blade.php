<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Shift', 'url' => route('master.shifts')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('shift-employee.shift-employee-list')
        </div>
    </div>
</div>
