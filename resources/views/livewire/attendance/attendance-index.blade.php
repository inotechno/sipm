<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Attendance', 'url' => route('attendance')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('attendance.attendance-list')
        </div>
    </div>
</div>
