<div>
    <div class="row">
        <h4 class="card-title">Attendance Gap Date {{ $dateString }} {{ $reference->name }}</h4>
        <div class="col-md-12">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <p class="text-muted text-truncate mb-2">Not Checkout</p>
                                <h5 class="mb-0" wire:loading.remove style="cursor: pointer;"
                                    wire:click="openModal('totalGapCheckInOnly', 'Attendance Gap Checkin Only', 'gapCheckInOnly')">
                                    {{ $totalGapCheckInOnly }}</h5>
                                <h6 class="mb-0" wire:loading wire:loading.class="text-muted">Loading...</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <p class="text-muted text-truncate mb-2">Not Checkin</p>
                                <h5 class="mb-0" wire:loading.remove style="cursor: pointer;"
                                    wire:click="openModal('totalGapCheckOutOnly', 'Attendance Gap Checkout Only', 'gapCheckOutOnly')">
                                    {{ $totalGapCheckOutOnly }}</h5>
                                <h6 class="mb-0" wire:loading wire:loading.class="text-muted">Loading...</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
