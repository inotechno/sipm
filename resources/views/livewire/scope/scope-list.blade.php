<div class="row">
    @foreach ($scopes as $scope)
        <div class="col-xl-4 col-sm-6">
            @livewire('scope.scope-item', ['scope' => $scope], key($scope->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $scopes->links() }}
    </div>
</div>
