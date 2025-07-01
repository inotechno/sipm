<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Dashboard']]], key('breadcrumb-component'))

    @can('dashboard.index')
        <div class="d-flex justify-content-end gap-2">
            <div class="mb-3">
                <label for="date">Filter Date</label>
                <input type="date" class="form-control" wire:model.live="date">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                @livewire('dashboard.attendance-stats', ['date' => $date], key('attendance-stats'))
            </div>
            <div class="col-md-6">
                @livewire('dashboard.attendance-stats-night', ['date' => $date], key('attendance-stats-night'))
            </div>
        </div>
{{--
        <div class="row">
            <div class="col-md">
                @livewire('dashboard.attendance-gap', ['date' => $date], key('attendance-gap'))
            </div>
            <div class="col-md">
                @livewire('dashboard.attendance-gap-night', ['date' => $date], key('attendance-gap-night'))
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md">
                @livewire('dashboard.attendance-per-position', ['date' => $date], key('attendance-per-position'))
            </div>

            <div class="col-md">
                @livewire('dashboard.attendance-per-position-night', ['date' => $date], key('attendance-per-position-night'))
            </div>
        </div>

        @livewire('dashboard.monitoring-general',['date' => $date], key('monitoring-general'))
        @livewire('dashboard.monitoring-supervisor',['date' => $date], key('monitoring-supervisor'))
    @endcan

    @livewire('component.modal.attendance-stats-modal', key('attendance-stats-modal'))
</div>
