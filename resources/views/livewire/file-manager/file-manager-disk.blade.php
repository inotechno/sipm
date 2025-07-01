<div class="card filemanager-sidebar ms-lg-2">
    <div class="card-body">
        <div class="text-center">
            <h5 class="font-size-15 mb-4">Storage</h5>
            @livewire(
                'widget.chart.radial-bar',
                [
                    'chart_id' => 'chart-diskusage',
                    'series' => [$percentage],
                    'colors' => ['--bs-primary'],
                    'labels' => ['Disk Usage'],
                ],
                key('chart-' . time())
            )

            <p class="text-muted mt-4">{{ $textDisk }}</p>
        </div>

        <div class="mt-4">
            @foreach ($categories as $category)
                <div class="card border shadow-none mb-2">
                    <a href="javascript:void(0);" class="text-body">
                        <div class="p-2">
                            <div class="d-flex">
                                <div class="avatar-xs align-self-center me-2">
                                    <div
                                        class="avatar-title rounded bg-transparent {{ $category['color'] }} font-size-20">
                                        <i class="mdi {{ $category['icon'] }}"></i>
                                    </div>
                                </div>

                                <div class="overflow-hidden me-auto">
                                    <h5 class="font-size-13 text-truncate mb-1">{{ $category['name'] }}</h5>
                                    <p class="text-muted text-truncate mb-0">{{ $category['files'] }} Files</p>
                                </div>

                                <div class="ms-2">
                                    <p class="text-muted">{{ $category['size'] }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
