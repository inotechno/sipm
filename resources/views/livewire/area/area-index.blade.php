<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'Area', 'url' => route('master.areas')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('area.area-list')
        </div>

        <div class="col-lg-4">
            @livewire('area.area-form', key('area-form'))
        </div>
    </div>

</div>
