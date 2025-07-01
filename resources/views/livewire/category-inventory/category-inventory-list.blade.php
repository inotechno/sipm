<div class="row">
    @foreach ($categories as $category)
        <div class="col-xl-4 col-sm-6">
            @livewire('category-inventory.category-inventory-item', ['category' => $category], key($category->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $categories->links() }}
    </div>
</div>
