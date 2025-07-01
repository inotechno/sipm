<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Monitoring Present', 'url' => route('monitoring.present')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('monitoring-present.monitoring-present-list')
        </div>
    </div>
</div>
