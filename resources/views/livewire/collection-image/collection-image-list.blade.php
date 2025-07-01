<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card job-filter">
                <div class="card-body">
                    <form action="javascript:void(0);">
                        <div class="row g-3">

                            <div class="col-md">
                                <select class="form-control select2" wire:model="filterSupervisor">
                                    <option>Supervisor</option>
                                    @foreach ($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md">
                                <input type="date" class="form-control" placeholder="Select date"
                                    wire:model="filterDate">
                            </div>
                            <div class="col-md-3 d-flex gap-2 align-items-center justify-content-center">
                                <button type="button" class="btn btn-soft-secondary" wire:click="filter"><i
                                        class="mdi mdi-filter-outline align-middle"></i> Filter</button>
                                <button type="button" class="btn btn-soft-danger" wire:click="resetFilter"><i
                                        class="mdi mdi-close align-middle"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($groupedImages as $group)
            <div class="col-12">
                @livewire('collection-image.collection-image-item', ['group' => $group], key($group['user_name'] . $group['upload_date']))
            </div>
        @empty
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="ri-image-2-line ri-3x text-muted mb-3"></i>
                        <h5>Belum ada data</h5>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="row">
        <div class="col-12">
            {{ $groupedImages->links() }}
        </div>
    </div>
</div>
