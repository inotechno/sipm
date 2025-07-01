<div class="row">
    @foreach ($groups as $group)
        <div class="col-xl-4 col-sm-5">
            @livewire('group.group-item', ['group' => $group], key($group->id))
        </div>
    @endforeach

    <div class="col-12">
        {{ $groups->links() }}
    </div>
</div>
