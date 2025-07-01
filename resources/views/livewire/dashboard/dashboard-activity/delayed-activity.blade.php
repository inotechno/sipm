<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Delayed Activities</h4>
            <p class="text-muted">Menampilkan jumlah aktivitas yang terlambat, sedang dikerjakan, dan tepat waktu.</p>

            <div id="delayed_activities" wire:ignore
                data-colors='["--bs-success","--bs-danger", "--bs-warning","--bs-info", "--bs-primary"]'
                class="apex-charts mt-4" dir="ltr"></div>

            <div id="delayed_activities_list" wire:ignore class="d-flex flex-wrap justify-content-between">
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                let chart;

                function renderChartIssueResolved(categories, dataSeries) {
                    let chartContainer = document.querySelector("#delayed_activities");
                    if (!chartContainer) return;

                    var pieChartColors = getChartColorsArray("delayed_activities");
                    if (!pieChartColors) return;

                    if (chart) {
                        chart.updateOptions({
                            series: dataSeries,
                            labels: categories
                        });
                    } else {
                        var options = {
                            chart: {
                                height: 320,
                                type: "donut"
                            },
                            series: dataSeries,
                            labels: categories,
                            colors: pieChartColors,
                            legend: {
                                show: true,
                                position: "top",
                                horizontalAlign: "center",
                                verticalAlign: "middle",
                                floating: false,
                                fontSize: "14px",
                                offsetX: 0,
                            },
                            yaxis: {
                                labels: {
                                    formatter: function(value) {
                                        return value + " ACTIVITIES";
                                    }
                                }
                            },
                        };

                        chart = new ApexCharts(chartContainer, options);
                        chart.render();

                    }

                    // 🔹 Generate Dynamic List Below Chart
                    var listContainer = document.getElementById("delayed_activities_list");
                    listContainer.innerHTML = "";
                    categories.forEach((label, index) => {
                        var color = pieChartColors[index % pieChartColors.length];
                        listContainer.innerHTML += `
                            <div class="flex-grow-1 text-center">
                                <p class="mb-2 text-truncate">
                                    <i class="mdi mdi-circle me-2" style="color: ${color};"></i> ${label}
                                </p>
                                <h4 class="mb-0" id="solved-count">${dataSeries[index]}</h4>
                            </div>
                        `;
                    });
                }

                renderChartIssueResolved(@json($categories), @json($data));

                Livewire.on('updateChartDelayedActivity', (eventData) => {
                    console.log(eventData.categories, eventData.data)
                    renderChartIssueResolved(eventData.categories, eventData.data);
                });
            })
        </script>
    @endpush
</div>
