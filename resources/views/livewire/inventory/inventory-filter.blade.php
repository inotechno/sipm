<div class="card">
    <div class="card-body">

        <h4 class="card-title mb-4">Filter</h4>

        <div>
            <h5 class="font-size-14 mb-3">Categories</h5>
            <ul class="list-unstyled product-list">
                @foreach ($categories as $category)
                    <li><a href="javascript: void(0);"><i class="mdi mdi-chevron-right me-1"></i>
                            {{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="mt-3 pt-3">
            <h5 class="font-size-14 mb-3">Warehouses</h5>
            <ul class="list-unstyled product-list">
                @foreach ($warehouses as $warehouse)
                    <li><a href="javascript: void(0);"><i class="mdi mdi-chevron-right me-1"></i>
                            {{ $warehouse->name }}</a></li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
