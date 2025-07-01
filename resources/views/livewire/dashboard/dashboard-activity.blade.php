<div>
    @livewire('component.layout.breadcrumb', ['breadcrumbs' => [['name' => 'Dashboard Activity']]], key('breadcrumb-component'))

    @can('dashboard.index')
        <div class="row my-3 justify-content-end">
            <div class="col-md-4">
                <div class="d-flex justify-content-end gap-2 align-items-center">
                    <input type="date" class="form-control flex-grow-1" wire:model="startDate">
                    <input type="date" class="form-control flex-grow-1" wire:model="endDate">

                    <button type="button" class="btn btn-primary flex-shrink-0 waves-effect waves-light"
                        wire:click="filterDate">Filter</button>
                </div>
            </div>
        </div>


        <div class="row" id="dashboard-activity">
            <div class="col-xl-4 item-dashboard-activity col-lg-6">
                @livewire('dashboard.dashboard-activity.delayed-activity', ['startDate' => $startDate, 'endDate' => $endDate], key('dashboard-delayed-activity'))
            </div>
            <div class="col-xl-4 item-dashboard-activity col-lg-6">
                @livewire('dashboard.dashboard-activity.activity-issue-resolved', ['startDate' => $startDate, 'endDate' => $endDate], key('dashboard-activity-issue-resolved'))
            </div>
            <div class="col-xl-4 item-dashboard-activity col-lg-6">
                @livewire('dashboard.dashboard-activity.activity-issue-by-area', ['startDate' => $startDate, 'endDate' => $endDate], key('dashboard-activity-issue-by-area'))
            </div>
            <div class="col-xl-6 col-lg item-dashboard-activity">
                @livewire('dashboard.dashboard-activity.activity-by-status', ['startDate' => $startDate, 'endDate' => $endDate], key('dashboard-activity-by-status'))
            </div>
            <div class="col-xl-6 col-lg-12 col-md item-dashboard-activity">
                @livewire('dashboard.dashboard-activity.activity-by-area', ['startDate' => $startDate, 'endDate' => $endDate], key('dashboard-activity-by-area'))
            </div>
            <div class="col-xl-6 col-lg-12 item-dashboard-activity">
                @livewire('dashboard.dashboard-activity.activity-progress', ['startDate' => $startDate, 'endDate' => $endDate], key('dashboard-activity-progress'))
            </div>
            <div class="col-xl-6 col-lg item-dashboard-activity">
            </div>
        </div>
    @endcan

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
            type="text/css">
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('libs/masonry-layout/masonry.pkgd.min.js') }}"></script>

        <script>
            function getChartColorsArray(e) {
                if (null !== document.getElementById(e)) {
                    var t = document.getElementById(e).getAttribute("data-colors");
                    if (t)
                        return (t = JSON.parse(t)).map(function(e) {
                            var t = e.replace(" ", "");
                            if (-1 === t.indexOf(",")) {
                                var r = getComputedStyle(document.documentElement).getPropertyValue(
                                    t
                                );
                                return r || t;
                            }
                            var o = e.split(",");
                            return 2 != o.length ?
                                t :
                                "rgba(" +
                                getComputedStyle(document.documentElement).getPropertyValue(
                                    o[0]
                                ) +
                                "," +
                                o[1] +
                                ")";
                        });
                    console.warn("data-colors Attribute not found on:", e);
                }
            }
        </script>

        <script>
            document.addEventListener('livewire:init', function() {
                // $('#dashboard-activity').masonry({
                //     itemSelector: '.item-dashboard-activity',
                // });
            })
        </script>
    @endpush
</div>
