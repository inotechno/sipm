<div>
    <div class="row mb-3">
        <div class="col-md">
            <label class="form-label">Filter Search</label>
            <input type="text" wire:model.live="filterSearch" class="form-control" placeholder="Search...">
        </div>

        <div class="col-md">
            <label class="form-label">Filter Supervisor</label>
            <select class="form-control" wire:model.live="filterGroup">
                <option>-- Select Group --</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->supervisor->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md" style="max-height: 400px; overflow-y: scroll">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">
                                {{-- <input type="checkbox" class="check-all form-check" @if ($checkAll) checked @endif wire:click="toggleCheckAll"> --}}
                            </th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr
                                wire:click="$dispatch('setSelectedEmployees', {employee: {{ json_encode($employee) }}})">
                                <td class="text-center">
                                    <input type="checkbox" id="check-{{ $employee->id }}" class="form-check"
                                        @if (in_array($employee->id, array_values($selectedEmployees))) checked @endif value="{{ $employee->id }}">
                                </td>
                                <td>{{ $employee->name }}</td>
                                <td class="text-center">{{ $employee->group?->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            tr {
                cursor: pointer;
                /* Ubah kursor menjadi pointer saat dihover */
            }

            tr:hover {
                background-color: #f8f9fa;
                /* Efek hover pada baris */
            }
        </style>
    @endpush
</div>
