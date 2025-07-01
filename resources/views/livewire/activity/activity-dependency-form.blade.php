<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Manage Dependency Activity' . $activity->scope->name, 'url' => route('activity.issues', ['activity_id' => $activity_id])]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                        @foreach ($dependencies as $index => $dependency)
                            <div class="dependency-group border rounded p-3 mb-3 row">
                                <div class="d-flex justify-content-end mb-2">
                                    @if ($index > 0)
                                        <button type="button" class="btn btn-danger btn-sm"
                                            wire:click="removeDependency({{ $index }})">
                                            Remove
                                        </button>
                                    @endif
                                </div>

                                <div class="col-md mb-3">
                                    <label class="form-label">Date</label>
                                    <p class="text-muted mb-2 font-size-10">
                                        Tanggal masalah
                                    </p>
                                    <input type="date"
                                        class="form-control @error('dependencies.' . $index . '.date') is-invalid @enderror"
                                        wire:model="dependencies.{{ $index }}.date">

                                    @error('dependencies.' . $index . '.date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md mb-3">
                                    <label class="form-label">Category Dependency</label>
                                    <p class="text-muted mb-2 font-size-10">
                                        Kategori masalah
                                    </p>
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

                                <div class="col-md mb-3">
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

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md mb-3">
                                            <label class="form-label">Description</label>
                                            <p class="text-muted mb-2 font-size-10">
                                                Jelaskan deskripsi masalah yang terjadi pada aktivitas ini secara detail.
                                            </p>
                                            <textarea class="form-control @error('dependencies.' . $index . '.description') is-invalid @enderror"
                                                wire:model="dependencies.{{ $index }}.description" rows="3"></textarea>

                                            @error('dependencies.' . $index . '.description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        @if ($isEditSolution)
                                            <div class="col-md mb-3">
                                                <label class="form-label">Solution</label>
                                                <p class="text-muted mb-2 font-size-10">
                                                    Solusi yang dilakukan untuk memperbaiki masalah pada aktivitas
                                                </p>
                                                <textarea @if (!$isEditSolution) disabled @endif
                                                    class="form-control @error('dependencies.' . $index . '.solution') is-invalid @enderror"
                                                    wire:model="dependencies.{{ $index }}.solution" rows="3"></textarea>

                                                @error('dependencies.' . $index . '.solution')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between gap-2">
                            <button type="button" class="btn btn-info flex-grow-1" wire:click="addDependency">
                                Add More Dependency
                            </button>
                            <button type="submit" class="btn btn-primary flex-grow-1">Submit</button>
                            <button type="button" class="btn btn-secondary flex-grow-1" wire:click="resetForm">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
