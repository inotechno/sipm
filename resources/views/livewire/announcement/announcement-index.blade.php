<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Announcement', 'url' => route('announcement')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            @livewire('announcement.announcement-list')
        </div>
    </div>
</div>
