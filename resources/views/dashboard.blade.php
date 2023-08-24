@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-lg-8 col-md-12">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar lg rounded-circle no-thumbnail"><i class="fa fa-shopping-cart fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="text-muted">Sales</div>
                                <h5 class="mb-0">$6,549</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar lg rounded-circle no-thumbnail"><i class="fa fa-credit-card fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="text-muted">Expense</div>
                                <h5 class="mb-0">$2,649</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar lg rounded-circle no-thumbnail"><i class="fa fa-credit-card fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="text-muted">Profits</div>
                                <h5 class="mb-0">$4,095</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title m-0">Net Sales</h6>
                            <div class="dropdown morphing scale-left">
                                <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="ac-line-transparent" id="apex-NetSales"></div>
                        </div>
                    </div> <!-- .card end -->
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Tickets</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                    </div>
                </div>
                <div class="bg-secondary text-light p-4 d-flex flex-wrap text-center">
                    <div class="px-2 flex-fill">
                        <span class="small">Total</span>
                        <h5 class="mb-0">500</h5>
                    </div>
                    <div class="px-2 flex-fill">
                        <span class="small">Personal</span>
                        <h5 class="mb-0">50</h5>
                    </div>
                    <div class="px-2 flex-fill">
                        <span class="small">Business</span>
                        <h5 class="mb-0">300</h5>
                    </div>
                    <div class="px-2 flex-fill">
                        <span class="small">Premium</span>
                        <h5 class="mb-0">150</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="apex-Tickets"></div>
                </div>
            </div> <!-- .card end -->
        </div>
    </div> <!-- .row end -->

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
                        text: 'TicketEvent'
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
            var chart = new ApexCharts(document.querySelector("#apex-TicketEvent"), options);
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
