<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Announcement Create', 'url' => route('announcement.create')]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0);" wire:submit.prevent="submit" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Subject</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" wire:model="subject" id="formrow-firstname-input"
                                        placeholder="Enter Subject" autocomplete="off" value="{{ old('subject') }}">

                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Recipient</label>
                                    <select name="recipients" wire:model="recipient" class="form-select">
                                        <option value="">Select Recipient</option>
                                        @foreach ($recipients as $recipient)
                                            <option value="{{ $recipient }}">{{ $recipient }}</option>
                                        @endforeach
                                    </select>

                                    @error('recipients')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" wire:model="description"
                                rows="10"></textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 d-flex justify-content-end gap-2">
                            <button class="btn btn-primary w-md" type="submit">Submit</button>
                            <button type="reset" class="btn btn-secondary w-md" wire:click="resetForm">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
