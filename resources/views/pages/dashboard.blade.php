@extends('main')

@section("content")

@endsection

@section('page-scripts')
    {{-- Scripts for this page goes here --}}
    <script>
        $(function () {
            // Net Sales
            var options = {
                series: [{
                    name: "Online",
                    data: [28, 29, 33, 28, 32, 32, 33]
                }, {
                    name: "Offline",
                    data: [12, 11, 14, 18, 17, 13, 13]
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 13,
                        left: 7,
                        blur: 5,
                        opacity: 0.1
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['var(--chart-color3)', 'var(--chart-color5)'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    borderColor: 'var(--border-color)',
                    row: {
                        colors: ['var(--border-color)', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    title: {
                        text: 'Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Tickets'
                    },
                    min: 5,
                    max: 50
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                }
            };
            var chart = new ApexCharts(document.querySelector("#apex-NetSales"), options);
            chart.render();
            // TICKETS sold
            var options = {
                series: [75, 12, 67, 29],
                chart: {
                    height: 340,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 0,
                        startAngle: 0,
                        endAngle: 270,
                        hollow: {
                            margin: 1,
                            size: '30%',
                            background: 'transparent',
                            image: undefined,
                        },
                        dataLabels: {
                            name: {
                                show: true,
                            },
                            value: {
                                show: true,
                            }
                        }
                    }
                },
                colors: ['var(--chart-color1)', 'var(--chart-color2)', 'var(--chart-color3)', 'var(--chart-color4)'],
                labels: ['Total', 'Personal', 'Business', 'Premium'],
                legend: {
                    show: true,
                    floating: true,
                    fontSize: '12px',
                    position: 'left',
                    offsetX: 10,
                    offsetY: 10,
                    labels: {
                        useSeriesColors: true,
                    },
                    markers: {
                        size: 0
                    },
                    formatter: function (seriesName, opts) {
                        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                    },
                    itemMargin: {
                        vertical: 3
                    }
                },
            };
            var chart = new ApexCharts(document.querySelector("#apex-Tickets"), options);
            chart.render();
        });
        $(function () {
            $('#myDataTable_no_filter').addClass('nowrap').dataTable({
                responsive: true,
                searching: false,
                paging: false,
                ordering: false,
                info: false,
            });
        });
    </script>
@endsection
