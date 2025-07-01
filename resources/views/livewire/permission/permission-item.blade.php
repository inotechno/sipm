<div class="card border shadow-none mb-2">
    <a href="javascript: void(0);" class="text-body">
        <div class="p-2">
            <div class="d-flex">
                <div class="avatar-xs align-self-center me-2">
                    <div class="avatar-title rounded bg-transparent text-success font-size-20">
                        {{ $permission->id }}
                    </div>
                </div>

                <div class="overflow-hidden me-auto">
                    <h5 class="font-size-13 text-truncate mb-1">{{ $permission->name }}</h5>
                    <p class="text-muted text-truncate mb-0">{{$permission->roles->count()}} Roles</p>
                </div>

                <div class="avatar-xs align-self-center ms-2">
                    <div class="avatar-title bg-warning rounded font-size-16" wire:click="$dispatch('permission-edit', { permission: {{ $permission }} })">
                        <i class="mdi mdi-pencil"></i>
                    </div>
                </div>
                <div class="avatar-xs align-self-center ms-2">
                    <div class="avatar-title bg-danger rounded font-size-16" wire:click="confirmDelete">
                        <i class="mdi mdi-delete"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
