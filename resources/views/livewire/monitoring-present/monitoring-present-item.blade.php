<div class="card task-box h-100 d-flex flex-column" id="uptask-2">
    <div class="card-body d-flex flex-column">
        <!-- Header Section -->
        <div class="mb-3">
            <div class="dropdown float-end">
                <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical m-0 text-muted h4"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    @can('monitoring.present.update')
                        <a href="javascript:void(0);" class="dropdown-item editMonitoring-details"
                            wire:click="$dispatch('show-canvas-dependency',{monitoring_details_id: {{ $monitoring_present->id }}})">
                            <i class="mdi mdi-pencil"></i>Edit Monitoring Detail</a>
                    @endcan

                    @can('monitoring.present.destroy')
                        <a class="dropdown-item editMonitoring-details" wire:click="confirmDelete"
                            href="javascript: void(0);">
                            <i class="mdi mdi-delete"></i> Delete</a>
                    @endcan
                </div>
            </div>
            <div class="float-end ms-2">
                <span class="badge badge-soft-primary font-size-12">
                    {{ $monitoring_present->shift->name }}
                </span>
                <span class="badge badge-soft-info font-size-12">{{ $monitoring_present->type }}</span>
            </div>
            <div>
                <h5 class="font-size-15">
                    <a href="javascript: void(0);" class="text-dark" id="task-name">{{ $monitoring_present->shift_date->format('d F Y') }}</a>
                </h5>
            </div>
        </div>

        <div class="flex-grow-1">
            <ul class="ps-3 mb-1 text-muted" id="task-desc">
                <li>Total Present: {{ $monitoring_present->total_present }}</li>
                <li>Total Absent: {{ $monitoring_present->total_absent }}</li>
                <li>Total Sick: {{ $monitoring_present->total_sick }}</li>
                <li>Total Leave: {{ $monitoring_present->total_leave }}</li>
                <li>Total Training: {{ $monitoring_present->total_training }}</li>
                <li>Total Pindah Supervisor: {{ $monitoring_present->total_move_supervisor }}</li>
                
                <li>Group: {{ $monitoring_present->group->name }}</li>
                <li>{{ $monitoring_present->roleName }}: {{ $monitoring_present->user->name }}</li>
            </ul>
        </div>

        <div class="mt-3">
            <button class="btn btn-light w-100" wire:click="$dispatch('show-modal-details', { monitoring_present_id: {{ $monitoring_present->id }}})">Show Details</button>
        </div>

    </div>
</div>
