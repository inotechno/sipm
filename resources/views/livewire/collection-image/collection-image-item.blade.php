<div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white align-middle">

            <h5 class="card-title mb-0">{{ $group['user_name'] }}</h5>
            <small class="text-light">Uploaded on: {{ $group['upload_date'] }}</small>

            @can('collection.image.destroy')
                <div class="float-end">
                    <button class="btn btn-sm btn-danger" wire:click="confirmDelete()">Delete</button>
                </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="row text-center">
            @foreach ($group['images'] as $image)
                <div class="col-md-4 mb-2">
                    <figure class="figure" style="text-align: center">
                        <img src="{{ $image->url }}" class="figure-img img-fluid rounded lazy-img"
                            style="max-height: 250px" alt="{{ $image->title }}" loading="lazy"
                            onload="this.classList.add('loaded')">
                        <figcaption class="figure-caption fw-bold text-muted font-size-12">{{ $image->title }} at
                            {{ $image->created_at->format('H:i') }}</figcaption>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>

    @push('styles')
        <style>
            .lazy-img {
                filter: blur(10px);
                transition: filter 0.3s ease-in-out;
            }

            .lazy-img.loaded {
                filter: blur(0);
            }
        </style>
    @endpush
</div>
