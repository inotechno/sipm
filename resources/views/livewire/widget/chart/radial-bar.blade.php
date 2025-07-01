<div>
    <div id="{{ $chart_id }}" data-colors='["--bs-primary"]' class="apex-charts"></div>

    @push('js')
        <script>
            document.addEventListener("livewire:init", function() {
                initChart(
                    @json($chart_id),
                    @json($series),
                    @json($labels),
                    @json($colors),
                    @json($height));

                Livewire.on('reloadChart', () => {
                    console.log('reloadChart');
                    initChart(
                        @json($chart_id),
                        @json($series),
                        @json($labels),
                        @json($colors),
                        @json($height));
                });
            });

            function validateChartData(series) {
                return Array.isArray(series) && series.length > 0 && series.every(num => !isNaN(num) && num !== null);
            }

            function initChart(chart_id, series, labels, colors, height) {
                let chartContainer = document.querySelector("#" + chart_id);
                if (!chartContainer) return;

                // Hapus chart lama jika sudah ada
                if (chartContainer.chartInstance) {
                    chartContainer.chartInstance.destroy();
                }

                let options = {
                    chart: {
                        height: height, // Default jika height undefined
                        type: "radialBar",
                        offsetY: -10
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -135,
                            endAngle: 135,
                            dataLabels: {
                                name: {
                                    fontSize: "13px",
                                    offsetY: 60
                                },
                                value: {
                                    offsetY: 22,
                                    fontSize: "16px",
                                    formatter: function(value) {
                                        return isNaN(value) ? "N/A" : value + "%"; // Tangani NaN
                                    },
                                },
                            },
                        },
                    },
                    colors: colors,
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: "dark",
                            shadeIntensity: 0.15,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 50, 65, 91],
                        },
                    },
                    stroke: {
                        dashArray: 4
                    },
                    series: series,
                    labels: labels || ["Progress"],
                };

                let chart = new ApexCharts(chartContainer, options);
                chart.render();
                chartContainer.chartInstance = chart;
            }
        </script>
    @endpush
</div>
