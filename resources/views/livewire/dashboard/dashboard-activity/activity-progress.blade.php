<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h4 class="card-title mb-4">Activities Progress</h4>
            <div class="ms-auto">
                <div class="btn-group" role="group">
                    <button wire:click="filterByToday" type="button" class="btn btn-sm btn-primary">Hari Ini</button>
                    <button wire:click="filterByWeek" type="button" class="btn btn-sm btn-secondary">Dalam
                        Seminggu</button>
                    <button wire:click="filterByMonth" type="button" class="btn btn-sm btn-success">Dalam
                        Sebulan</button>
                </div>
            </div>
        </div>

        <p class="text-muted">Menampilkan progress per scope aktivitas dengan nilai berdasarkan quantity.</p>

        <div wire:loading wire:target="filterByToday, filterByWeek, filterByMonth">
            <div class="d-flex justify-content-center mt-3">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <div id="progress_chart" wire:ignore
            data-colors='["--bs-success","--bs-danger", "--bs-warning","--bs-info", "--bs-primary"]' class="apex-charts"
            dir="ltr">
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                let chart;

                function renderChartActivityProgress(categories, dataSeries) {
                    let chartContainer = document.querySelector("#progress_chart");
                    if (!chartContainer) return;

                    if (chart) {
                        chart.updateOptions({
                            series: dataSeries,
                            xaxis: {
                                categories: categories
                            }
                        });
                    } else {
                        var progressChartColors = getChartColorsArray("progress_chart");
                        if (!progressChartColors) return;

                        var options = {
                            chart: {
                                height: 350,
                                type: "line",
                                zoom: {
                                    enabled: false
                                },
                                toolbar: {
                                    show: false
                                }
                            },
                            colors: progressChartColors,
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                width: 4,
                                curve: "smooth"
                            },
                            series: dataSeries,
                            xaxis: {
                                categories: categories,
                            },
                            yaxis: {
                                title: {
                                    text: "Jumlah Progress (Qty)",
                                },
                            },
                            grid: {
                                borderColor: "#f1f1f1"
                            },
                            legend: {
                                position: "bottom",
                                horizontalAlign: "right"
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + " Qty";
                                    }
                                }
                            },
                        };

                        chart = new ApexCharts(chartContainer, options);
                        chart.render();
                    }
                }

                // Render pertama kali
                renderChartActivityProgress(@json($chartCategories), @json($chartData));

                // Update chart saat event diterima dari Livewire
                Livewire.on('updateProgressChart', (eventData) => {
                    console.log(eventData);
                    renderChartActivityProgress(eventData.categories, eventData.data);
                });
            });
        </script>
    @endpush

</div>
