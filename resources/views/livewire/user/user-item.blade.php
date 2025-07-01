<div class="card text-center">
    <div class="card-body">
        <div class="avatar-sm mx-auto mb-4">
            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                {{ substr($user->name, 0, 1) }}
            </span>
        </div>
        <h5 class="font-size-15 mb-1"><a href="javascript: void(0);" class="text-dark">{{ $user->name }}</a></h5>
        <p class="text-muted">{{ $user->email }}</p>

        <div>
            @foreach ($user->roles as $role)
                <a href="javascript: void(0);" class="badge bg-primary font-size-11 m-1">{{ $role->name }}</a>
            @endforeach
        </div>
    </div>
    <div class="card-footer bg-transparent border-top">
        <div class="contact-links d-flex font-size-20">
            <div class="flex-fill">
                    <a href="javascript: void(0);" class="text-success" wire:click="$dispatch('user-edit', { user: {{ $user }} })">
                    {{-- Edit --}}
                    <i class="bx bx-edit-alt"></i>
                </a>
            </div>
            <div class="flex-fill">
                <a href="javascript: void(0);" class="text-danger" wire:click="confirmDelete">
                    {{-- Delete --}}
                    <i class="bx bx-trash-alt"></i>
                </a>
            </div>
            <div class="flex-fill">
                <a href="javascript: void(0);" class="text-info">
                    {{-- Detail --}}
                    <i class="bx bx-detail"></i>
                </a>
            </div>
        </div>
    </div>
</div>
