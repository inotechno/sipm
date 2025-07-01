<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Outbound Create', 'url' => route('inventory.outbound')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-2">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">OPTION</h4>

                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Is Group?</label>
                        <select class="form-select @error('is_group') is-invalid @enderror" wire:model.live="is_group">
                            <option value="">-- Select --</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>

                        @error('is_group')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Supervisor</label>
                        <select class="form-select @error('supervisor_id') is-invalid @enderror"
                            wire:model="supervisor_id" id="supervisor_id"
                            @if (!$is_group) disabled @endif>
                            <option value="">-- Select Supervisor --</option>
                            @foreach ($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}">{{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('supervisor_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Employee</label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" wire:model="employee_id"
                            id="employee_id" @if ($is_group) disabled @endif>
                            <option value="">-- Select Employee --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>

                        @error('employee_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg">
            <div class="row mb-3">
                <div class="col-xl">
                    <div class="mt-2">
                        <h5>BARANG BELUM DI KEMBALIKAN</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($inventory_borrows) > 0)
                    @foreach ($inventory_borrows as $detail)
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-header bg-light border-bottom text-end">
                                    <span>Waktu Pinjam: {{ $detail->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-4">
                                            <div class="avatar-md">
                                                <span
                                                    class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16">
                                                    {{ substr($detail->inventory->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>


                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-truncate font-size-15"><a href="javascript: void(0);"
                                                    class="text-dark">{{ $detail->inventory->name }}
                                                    ({{ $detail->inventory->serial_number }})
                                                </a></h5>
                                            <p class="text-muted mb-1">{{ $detail->inventory->warehouse->name }}</p>
                                            <p class="text-muted mb-1">{{ $detail->inventory->category->name }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-3 justify-content-between">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item me-3">
                                                @if ($detail->inventory->type == 'Consumable')
                                                    <span class="badge bg-success">Consumable</span>
                                                @elseif($detail->inventory->type == 'Asset')
                                                    <span class="badge bg-warning">Asset</span>
                                                @else
                                                    <span class="badge bg-info">Service</span>
                                                @endif
                                            </li>
                                            <li class="list-inline-item me-3">
                                                <i class="bx bx-user me-1"></i> {{ $detail->createdBy->name }}
                                            </li>
                                            <li class="list-inline-item me-3">
                                                <i class="bx bx-briefcase me-1"></i> {{ $detail->quantity }}
                                                {{ $detail->inventory->unit }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-footer bg-light border-top">
                                    <ul class="list-inline mb-0 text-end">
                                        <li class="list-inline-item">
                                            @if (in_array($detail->id, array_column($selectedTransactionDetails, 'id')))
                                                <button class="btn btn-sm btn-success" disabled><span
                                                        class="bx bx-check"></span> Selected</button>
                                            @else
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="selectTransaction('{{ $detail->id }}')"><span
                                                        class="bx bx-send"></span> Select</button>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <h4 class="mt-3">Data
                                        Empty</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md col-lg-4">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">PROCESS SUBMIT OUTBOUND</h4>

                    <div class="table-responsive">
                        <table class="table w-100 table-nowrap table-sm align-middle table-hover mb-3">
                            <tbody>
                                @if (count($selectedTransactionDetails) > 0)
                                    @foreach ($selectedTransactionDetails as $detail)
                                        <tr>
                                            <td>
                                                <h5 class="text-truncate font-size-14 mb-1"><a
                                                        href="javascript: void(0);" class="text-dark"></a>
                                                    {{ $detail['name'] }}</h5>
                                            </td>
                                            <td width="20%">
                                                <input type="number"
                                                    class="form-control form-control-sm @error('quantity') is-invalid @enderror"
                                                    wire:model="selectedTransactionDetails.{{ $detail['id'] }}.quantity"
                                                    readonly>

                                                @error('quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td width="10%">
                                                <a href="javascript: void(0);"
                                                    wire:click="removeTransaction('{{ $detail['id'] }}')"
                                                    class="text-danger p-1"><i class="bx bxs-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="mb-2">
                                                    <label for="">Note</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        wire:model="selectedTransactionDetails.{{ $detail['id'] }}.note">
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="mb-2">
                                                    <label for="">Condition</label>
                                                    <select name="condition_return" class="form-select form-select-sm" id=""
                                                        wire:model="selectedTransactionDetails.{{ $detail['id'] }}.condition_return">
                                                        <option value="">-- Select Condition --</option>
                                                        <option value="good">Good</option>
                                                        <option value="broken">Broken</option>
                                                        <option value="bad">Bad</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mb-3 d-flex gap-2 align-items-stretch">
                            <button class="btn btn-primary w-100" wire:click="submit">Submit</button>
                            <button class="btn btn-secondary w-100" wire:click="resetForm">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            var selectSupervisor = $('#supervisor_id');
            var selectEmployee = $('#employee_id');

            function initSelect2() {
                selectSupervisor.select2({
                    placeholder: 'Select an option',
                    width: '100%',
                });

                selectEmployee.select2({
                    placeholder: 'Select an option',
                    width: '100%',
                });
            }

            document.addEventListener('livewire:init', function() {
                initSelect2();

                selectSupervisor.on('change', function() {
                    Livewire.dispatch('updateSelect2', {
                        model: 'supervisor_id',
                        value: this.value
                    });
                });

                selectEmployee.on('change', function() {
                    Livewire.dispatch('updateSelect2', {
                        model: 'employee_id',
                        value: this.value
                    });
                });

                Livewire.on('refreshSelect2', function() {
                    setTimeout(function() {
                        initSelect2();
                    }, 500);
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    initSelect2();
                }, 500);
            });

            document.addEventListener("livewire:navigated", function() {
                setTimeout(function() {
                    initSelect2();
                }, 500);
            });
        </script>
    @endpush
</div>
