<div class="row">
    @foreach ($roles as $role)
        <div class="col-xl-4 col-sm-6">
            @livewire('role.role-item', ['role' => $role], key($role->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $roles->links() }}
    </div>
</div>
