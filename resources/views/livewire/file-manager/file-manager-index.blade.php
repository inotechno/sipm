<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'File Manager', 'url' => route('files')]]], key('breadcrumb'))

    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">
                @livewire('file-manager.file-manager-folder', ['slug' => $slug], key('file-manager-folder'))

                @livewire('file-manager.file-manager-list', ['slug' => $slug], key('file-manager-list'))
            </div>
        </div>

        @livewire('file-manager.file-manager-disk', key('file-manager-disk'))
    </div>

</div>
