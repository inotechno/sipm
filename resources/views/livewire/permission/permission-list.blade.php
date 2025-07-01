<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="search" wire:model.live.debounce.500ms="search">
                <label for="search">Search</label>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($permissions as $permission)
            <div class="col-xl-4 col-sm-6">
                @livewire('permission.permission-item', ['permission' => $permission], key($permission->id))
            </div>
        @endforeach

        <div class="col-12">
            {{ $permissions->links() }}
        </div>
    </div>

</div>
