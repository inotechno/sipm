<div>
    <div class="offcanvas-header">
        <h5 id="offcanvasBottomLabel">Add Activity Dependency</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form wire:submit.prevent="submit" class="needs-validation" novalidate>
            @foreach ($dependencies as $index => $dependency)
                <div class="dependency-group border rounded p-3 mb-3">
                    <div class="d-flex justify-content-end mb-2">
                        @if ($index > 0)
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="removeDependency({{ $index }})">
                                Remove
                            </button>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date"
                            class="form-control @error('dependencies.' . $index . '.date') is-invalid @enderror"
                            wire:model="dependencies.{{ $index }}.date">

                        @error('dependencies.' . $index . '.date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Dependency</label>
                        <select
                            class="form-control @error('dependencies.' . $index . '.category_dependency_id') is-invalid @enderror"
                            wire:model.live="dependencies.{{ $index }}.category_dependency_id">
                            <option value="">-- Select Category Dependency --</option>
                            @foreach ($category_dependencies as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @error('dependencies.' . $index . '.category_dependency_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Percentage Dependency</label>
                        <p class="text-muted mb-2 font-size-10">
                            Berapa persentase masalah mempengaruhi aktivitas ini
                        </p>
                        <input type="number"
                            class="form-control @error('dependencies.' . $index . '.percentage_dependency') is-invalid @enderror"
                            wire:model="dependencies.{{ $index }}.percentage_dependency">

                        @error('dependencies.' . $index . '.percentage_dependency')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if ($isEditDescription)
                        <div class="mb-3">
                            <label class="form-label">Solution</label>
                            <p class="text-muted mb-2 font-size-10">
                                Solusi yang dilakukan untuk memperbaiki masalah pada aktivitas
                            </p>
                            <textarea @if (!$isEditDescription) disabled @endif
                                class="form-control @error('dependencies.' . $index . '.description') is-invalid @enderror"
                                wire:model="dependencies.{{ $index }}.description" rows="3"></textarea>

                            @error('dependencies.' . $index . '.description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="mb-3">
                <button type="button" class="btn btn-secondary w-100" wire:click="addDependency">
                    Add More Dependency
                </button>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary w-md">Submit</button>
                <button type="button" class="btn btn-secondary w-md" wire:click="resetForm">Reset</button>
            </div>
        </form>

    </div>

    @push('styles')
        <style>
            .offcanvas-scrollable {
                max-height: 100%;
                overflow-y: auto;
            }
        </style>
    @endpush

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                Livewire.on('showFormDependency', () => {
                    const offcanvasElement = document.getElementById('addActivityDependency');

                    // Pastikan Offcanvas Bootstrap diinisialisasi
                    let bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                    if (!bsOffcanvas) {
                        bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
                    }

                    // Tampilkan offcanvas
                    bsOffcanvas.show();
                });

                Livewire.on('hideFormDependency', () => {
                    const offcanvasElement = document.getElementById('addActivityDependency');

                    // Pastikan Offcanvas Bootstrap diinisialisasi
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }
                });
            });
        </script>
    @endpush
</div>
