<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Monitoring Present Day Date {{ $dateString }} {{ $shift->name }}</h4>
                    <p class="card-title-desc">21:00 - 23:00 | 02:00 - 04:00</p>
                </div>

                <div class="col-6 d-flex justify-content-end gap-2 mb-2">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" wire:model.live="date">
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <select class="form-select" wire:model.live="type" id="time">
                            <option selected value="">-- Select Time --</option>
                            <option value="in">21:00 - 23:00</option>
                            <option value="in_break">02:00 - 04:00</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
            <div class="col-12" wire:loading>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="col-12" wire:loading.remove>
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead>
                            <tr class="text-center align-middle">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Group</th>
                                <th colspan="2">Monitor Supervisor</th>
                                <th colspan="2">Monitor HSE</th>
                            </tr>
                            <tr class="text-center align-middle">
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Present</th>
                                <th>Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($monitoring_presents as $groupId => $data)
                                <tr class="text-center align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">
                                    {{ $data->first()->group->name ?? 'Group not found' }} 
                                    {{ $data->first()->group->supervisor->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $data->where('role', 'supervisor')->sum(fn($item) => $item->details->where('is_present', 1)->count()) }}
                                    </td>
                                    <td>
                                        {{ $data->where('role', 'supervisor')->sum(fn($item) => $item->details->where('is_present', 0)->count()) }}
                                    </td>
                                    <td>
                                        {{ $data->where('role', 'hse')->sum(fn($item) => $item->details->where('is_present', 1)->count()) }}
                                    </td>
                                    <td>
                                        {{ $data->where('role', 'hse')->sum(fn($item) => $item->details->where('is_present', 0)->count()) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
