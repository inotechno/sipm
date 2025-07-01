<div class="card">
    <div class="card-body">
        <h4 class="card-title">Activity Issue By Area</h4>
        <p class="text-muted">Menampilkan jumlah issue per area</p>

        <div id="dependency_by_area_chart" wire:ignore
            data-colors='["--bs-success","--bs-danger", "--bs-warning","--bs-info", "--bs-primary"]'
            class="apex-charts mt-4" dir="ltr"></div>

        <div id="dependency_by_area_chart_list" wire:ignore class="d-flex flex-wrap justify-content-between">
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                let chart;

                function renderChartIssueArea(categories, dataSeries) {
                    let chartContainer = document.querySelector("#dependency_by_area_chart");
                    if (!chartContainer) return;

                    var pieChartColors = getChartColorsArray("dependency_by_area_chart");
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
                    var listContainer = document.getElementById("dependency_by_area_chart_list");
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

                renderChartIssueArea(@json($categories), @json($data));

                Livewire.on('updateChartIssueArea', (eventData) => {
                    console.log(eventData.categories, eventData.data)
                    renderChartIssueArea(eventData.categories, eventData.data);
                });
            })
        </script>
    @endpush
</div>
