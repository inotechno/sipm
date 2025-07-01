<div class="row">
    @foreach ($positions as $position)
        <div class="col-xl-4 col-sm-6">
            @livewire('position.position-item', ['position' => $position], key($position->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $positions->links() }}
    </div>
</div>
