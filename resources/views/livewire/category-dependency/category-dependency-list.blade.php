<div class="row">
    @foreach ($category_dependencies as $category_dependency)
        <div class="col-xl-4 col-sm-6">
            @livewire('category-dependency.category-dependency-item', ['category_dependency' => $category_dependency], key($category_dependency->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $category_dependencies->links() }}
    </div>
</div>
