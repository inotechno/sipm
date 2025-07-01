<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Activity', 'url' => route('activity')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('activity.activity-list')
        </div>
    </div>


    <div class="offcanvas offcanvas-end offcanvas-scrollable" tabindex="-1" id="addActivityCanvas" aria-labelledby="addActivityCanvasLabel" data-bs-backdrop="static"
    data-bs-keyboard="false" data-bs-scroll="true">
        @livewire('activity.activity-form', key('activity-form'))
    </div>

</div>
