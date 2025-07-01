<div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-end">
                <div class="flex-shrink-0">
                    @can('announcement.create')
                        <a href="{{ route('announcement.create') }}" class="btn btn-primary">Add New Announcement</a>
                    @endcan

                    <a href="#!" class="btn btn-light" wire:click="$dispatch('refreshIndex')"><i
                            class="mdi mdi-refresh"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($announcements as $announcement)
            <div class="col-md-4 col-lg-3 mb-3">
                @livewire('announcement.announcement-item', ['announcement' => $announcement, 'number' => $loop->iteration], key('announcement-item-' . $announcement->id . time()))
            </div>
        @endforeach

        <div class="col-lg-12">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
