<div class="row">
    @foreach ($areas as $area)
        <div class="col-xl-4 col-sm-6">
            @livewire('area.area-item', ['area' => $area], key($area->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $areas->links() }}
    </div>
</div>
