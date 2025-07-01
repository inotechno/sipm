<div class="card border shadow-none mb-2">
    <a href="javascript: void(0);" class="text-body">
        <div class="p-2">
            <div class="d-flex">
                <div class="avatar-xs align-self-center me-2">
                    <div class="avatar-title rounded bg-transparent text-success font-size-20">
                        {{ $group->id }}
                    </div>
                </div>

                <div class="overflow-hidden me-auto">
                    <h5 class="font-size-13 text-wrap mb-1" title="Supervisor">{{ $group->name }}
                        ({{ $group->supervisor?->name }}) </h5>
                    <p class="text-muted text-truncate mb-0">{{ $group->employees->count() }} Employees</p>
                </div>

                @can('group.edit')
                    <div class="d-flex gap-2 align-self-center">

                        <button class="btn btn-sm btn-soft-primary waves-effect waves-light align-self-center font-size-16"
                            wire:click="$dispatch('group-edit', { group: {{ $group }} })" title="Edit">
                            <i class="mdi mdi-pencil"></i>
                        </button>

                        <button class="btn btn-sm btn-soft-danger waves-effect waves-light align-self-center font-size-16"
                            wire:click="confirmDelete" title="Delete">
                            <i class="mdi mdi-delete"></i>
                        </button>

                        <button class="btn btn-sm btn-soft-primary waves-effect waves-light align-self-center font-size-16"
                            wire:click="$dispatch('show-form-add-group', { group_id: {{ $group->id }} })"
                            title="Add Employee">
                            <i class="mdi mdi-account-plus"></i>
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </a>
</div>
