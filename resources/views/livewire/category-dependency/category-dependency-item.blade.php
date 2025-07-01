<div class="card border shadow-none mb-2">
    <a href="javascript: void(0);" class="text-body">
        <div class="p-2">
            <div class="d-flex">
                <div class="avatar-xs align-self-center me-2">
                    <div class="avatar-title rounded bg-transparent text-success font-size-20">
                        <i class="bx bx-briefcase"></i>
                    </div>
                </div>

                <div class="overflow-hidden me-auto">
                    <h5 class="font-size-13 text-truncate mb-1">{{ $category_dependency->name }}</h5>
                    <p class="text-muted text-truncate mb-0">{{$category_dependency->activityIssues->count()}} Activity</p>
                </div>

                <div class="avatar-xs align-self-center ms-2">
                    <div class="avatar-title bg-warning rounded font-size-16" wire:click="$dispatch('category_dependency-edit', { category_dependency: {{ $category_dependency }} })">
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
