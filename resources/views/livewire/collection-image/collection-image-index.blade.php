<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Daily Image', 'url' => route('collection.images')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-3">
            @livewire('collection-image.collection-image-form', key('collection-image-form'))
        </div>
        <div class="col-lg">
            @livewire('collection-image.collection-image-list', key('collection-image-list'))
        </div>
    </div>
</div>
