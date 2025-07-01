<div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="search" wire:model.live.debounce.500ms="search">
                <label for="search">Search</label>
            </div>
        </div>
    </div>
    
    <div class="row">
        @foreach ($users as $user)
            <div class="col-xl-4 col-sm-6">
                @livewire('user.user-item', ['user' => $user], key('user-item-'.$user->id.time()))
            </div>
        @endforeach

        <div class="col-12">
            {{ $users->links('vendor.livewire.bootstrap') }}
        </div>
    </div>
</div>
