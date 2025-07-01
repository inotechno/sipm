<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Profile', 'url' => '/']]], key('breadcrumb'))

    <div class="d-flex justify-content-center">
        @livewire('profile.profile-form', key('profile-form'))
    </div>
</div>
