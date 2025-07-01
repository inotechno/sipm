<div class="row">
    @foreach ($warehouses as $warehouse)
        <div class="col-xl-4 col-sm-6">
            @livewire('warehouse.warehouse-item', ['warehouse' => $warehouse], key($warehouse->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $warehouses->links() }}
    </div>
</div>
