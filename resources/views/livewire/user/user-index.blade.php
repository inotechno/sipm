<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Master Data', 'url' => '/'], ['name' => 'User & Role', 'url' => route('master.users')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-8">
            @livewire('user.user-list')
        </div>

        <div class="col-lg-4">
            @livewire('user.user-form', key('user-form'))
        </div>
    </div>
</div>
