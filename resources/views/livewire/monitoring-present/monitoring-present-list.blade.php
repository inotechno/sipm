<div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-end">
                <div class="flex-shrink-0">
                    <a href="#!" class="btn btn-primary" wire:click="$dispatch('showModalAddMonitoring')">Add New
                        Monitoring</a>
                    <a href="#!" class="btn btn-light" wire:click="$dispatch('refreshIndex')"><i
                            class="mdi mdi-refresh"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">
                            <div class="col-xxl-2 col-lg-6 form-floating">
                                <select class="form-select" id="selectGroup" wire:model="filterGroup">
                                    <option selected value="">-- Select Group --</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                                <label for="selectGroup">Filter Select Group</label>
                            </div>
                            <div class="col-xxl-2 col-lg-4 form-floating">
                                <select class="form-select" id="filterShift" wire:model="filterShift">
                                    <option selected value="">-- Select Shift --</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}
                                            {{ $shift->day_of_week }}</option>
                                    @endforeach
                                </select>
                                <label for="filterShift">Filter Select Shift</label>
                            </div>
                            <div class="col-xxl-2 col-lg-4 form-floating">
                                <select class="form-select" id="filterType" wire:model="filterType">
                                    <option selected value="">-- Select Type --</option>
                                    <option value="08">08:00</option>
                                    <option value="09">09:00</option>
                                    <option value="10">10:00</option>
                                    <option value="14">14:00</option>
                                    <option value="15">15:00</option>
                                    <option value="16">16:00</option>
                                    <option value="18">18:00</option>
                                    <option value="20">20:00</option>
                                    <option value="21">21:00</option>
                                    <option value="22">22:00</option>
                                    <option value="02">02:00</option>
                                    <option value="03">03:00</option>
                                    <option value="04">04:00</option>
                                    <option value="06">06:00</option>
                                </select>
                                <label for="filterType">Filter Select Time</label>
                            </div>
                            <div class="col-xxl-2 col-lg-4 form-floating">
                                <input type="date" class="form-control" id="filterStartDate"
                                    wire:model="filterStartDate">
                                <label for="filterStartDate">Filter Start Date</label>
                            </div>
                            <div class="col-xxl-2 col-lg-4 form-floating">
                                <input type="date" class="form-control" id="filterEndDate"
                                    wire:model="filterEndDate">
                                <label for="filterEndDate">Filter End Date</label>
                            </div>
                            <div class="col-xxl-2 col-lg-4 d-flex gap-2 align-items-center justify-content-center">
                                <button type="button" class="btn btn-soft-secondary" wire:click="filter"><i
                                        class="mdi mdi-filter-outline align-middle"></i> Filter</button>
                                <button type="button" class="btn btn-soft-danger" wire:click="resetFilter"><i
                                        class="mdi mdi-close align-middle"></i> Reset</button>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        @foreach ($monitoring_presents as $monitoring_present)
            <div class="col-md-3 mb-3">
                @livewire('monitoring-present.monitoring-present-item', ['monitoring_present' => $monitoring_present], key($monitoring_present->id . time()))
            </div>
        @endforeach

    </div>

    <div class="row">

        <div class="col-lg-12">
            {{ $monitoring_presents->links() }}
        </div>

    </div>
    @livewire('monitoring-present.monitoring-present-form', ['groups' => $groups], key('monitoring-present-form'))
    @livewire('monitoring-present.monitoring-present-detail', key('monitoring-present-detail'))
</div>
