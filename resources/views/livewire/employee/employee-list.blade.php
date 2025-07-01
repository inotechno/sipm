<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="search" wire:model.live.debounce.500ms="search">
                <label for="search">Search</label>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($employees as $employee)
            <div class="col-xl-4 col-sm-6">
                @livewire('employee.employee-item', ['employee' => $employee], key('employee-item-' . $employee->id . time()))
            </div>
        @endforeach

        <div class="col-12">
            {{ $employees->links() }}
        </div>
    </div>
</div>
