<div>
    <div class="row">
        <h4 class="card-title">Attendance Status Date {{ $dateString }} {{ $reference->name }}</h4>
        <div class="col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">IN</p>
                            <h4 class="mb-0" wire:loading.remove>{{ $totalIN }}</h4>
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

                    <div class="d-flex mt-4 gap-3">
                        <span class="badge badge-soft-success font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalin', '{{ $title_in['ontime'] }}', 'employees_ontime_in')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_in['ontime'] }}"><i
                                class="mdi mdi-clock me-1"></i>
                            {{ $totalin['ontime'] }}</span></span>
                        <span class="badge badge-soft-danger font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalin', '{{ $title_in['late'] }}', 'employees_late_in')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_in['late'] }}"><i
                                class="mdi mdi-arrow-down me-1"></i>
                            {{ $totalin['late'] }}</span></span>
                        <span class="badge badge-soft-info font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalin', '{{ $title_in['early'] }}', 'employees_early_in')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_in['early'] }}"><i
                                class="mdi mdi-arrow-up me-1"></i>
                            {{ $totalin['early'] }}</span></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Break IN</p>
                            <h4 class="mb-0" wire:loading.remove>{{ $totalBreakIn }}</h4>
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

                    <div class="d-flex mt-4 gap-3">
                        <span class="badge badge-soft-success font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalbreak_in', '{{ $title_break_in['ontime'] }}', 'employees_ontime_break_in')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_break_in['ontime'] }}"><i
                                class="mdi mdi-clock me-1"></i>
                            {{ $totalbreak_in['ontime'] }}</span></span>
                        <span class="badge badge-soft-danger font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalbreak_in', '{{ $title_break_in['late'] }}', 'employees_late_break_in')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_break_in['late'] }}"><i
                                class="mdi mdi-arrow-down me-1"></i>
                            {{ $totalbreak_in['late'] }}</span></span>
                        <span class="badge badge-soft-info font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalbreak_in', '{{ $title_break_in['early'] }}', 'employees_early_break_in')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_break_in['early'] }}"><i
                                class="mdi mdi-arrow-up me-1"></i>
                            {{ $totalbreak_in['early'] }}</span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Break OUT</p>
                            <h4 class="mb-0" wire:loading.remove>{{ $totalBreakOut }}</h4>
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

                    <div class="d-flex mt-4 gap-3">
                        <span class="badge badge-soft-success font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalbreak_out', '{{ $title_break_out['ontime'] }}', 'employees_ontime_break_out')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_break_out['ontime'] }}"><i
                                class="mdi mdi-clock me-1"></i>
                            {{ $totalbreak_out['ontime'] }}</span></span>
                        <span class="badge badge-soft-danger font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalbreak_out', '{{ $title_break_out['late'] }}', 'employees_late_break_out')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_break_out['late'] }}"><i
                                class="mdi mdi-arrow-down me-1"></i>
                            {{ $totalbreak_out['late'] }}</span></span>
                        <span class="badge badge-soft-info font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalbreak_out', '{{ $title_break_out['early'] }}', 'employees_early_break_out')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_break_out['early'] }}"><i
                                class="mdi mdi-arrow-up me-1"></i>
                            {{ $totalbreak_out['early'] }}</span></span>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">OUT</p>
                            <h4 class="mb-0" wire:loading.remove>{{ $totalOUT }}</h4>
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

                    <div class="d-flex mt-4 gap-3">
                        <span class="badge badge-soft-success font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalout', '{{ $title_out['ontime'] }}', 'employees_ontime_out')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_out['ontime'] }}"><i
                                class="mdi mdi-clock me-1"></i>
                            {{ $totalout['ontime'] }}</span></span>
                        <span class="badge badge-soft-danger font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalout', '{{ $title_out['late'] }}', 'employees_late_out')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_out['late'] }}"><i
                                class="mdi mdi-arrow-down me-1"></i>
                            {{ $totalout['late'] }}</span></span>
                        <span class="badge badge-soft-info font-size-12" style="cursor: pointer;"
                            wire:click="openModal('totalout', '{{ $title_out['early'] }}', 'employees_early_out')"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $title_out['early'] }}"><i
                                class="mdi mdi-arrow-up me-1"></i>
                            {{ $totalout['early'] }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
