<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label for="title">Judul Gambar</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model="title">

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image">Pilih Gambar <small class="text-danger">* Maksimal 2MB</small></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" wire:model="image">

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="text-center mb-3">
                    <div wire:loading wire:target="image">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <img src="{{ $previewImage }}" alt="Preview Image" class="img-preview img-fluid" wire:loading.remove wire:target="image">
                </div>

                <div class="d-flex gap-2 mb-3">
                    <button type="submit" class="btn btn-primary flex-grow-1" wire:click.prevent="store">Simpan</button>
                    <button type="button" class="btn btn-secondary flex-grow-1" wire:click="resetForm">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
