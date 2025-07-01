<div>
    <div class="card mini-stats-wid"
        wire:click="openModal"
        style="cursor: pointer;">
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <p class="text-muted fw-medium">{{ $title }}</p>
                    <h4 class="mb-0" wire:loading.remove>{{ $value }}</h4>
                    <h6 class="mb-0" wire:loading wire:loading.class="text-muted">Loading...</h6>
                </div>

                <div class="flex-shrink-0 align-self-center">
                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                        <span class="avatar-title">
                            <i class="bx bx-copy-alt font-size-24"></i>
                        </span>
                    </div>
                </div>
            </div>

            {{-- <div class="d-flex mt-4 gap-3">
                <span class="badge badge-soft-success font-size-12" data-bs-toggle="tooltip" data-bs-placement="top" title="On Time"><i class="mdi mdi-clock me-1"></i> 17</span></span>
                <span class="badge badge-soft-danger font-size-12" data-bs-toggle="tooltip" data-bs-placement="top" title="Late"><i class="mdi mdi-arrow-down me-1"></i> 17</span></span>
                <span class="badge badge-soft-info font-size-12" data-bs-toggle="tooltip" data-bs-placement="top" title="Early"><i class="mdi mdi-arrow-up me-1"></i> 17</span></span>
            </div> --}}
        </div>
    </div>
</div>
