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
                                <a href="#" class="more-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                <ul class="dropdown-menu shadow border-0 p-2">
                                    <li><a class="dropdown-item" href="#">File Info</a></li>
                                    <li><a class="dropdown-item" href="#">Copy to</a></li>
                                    <li><a class="dropdown-item" href="#">Move to</a></li>
                                    <li><a class="dropdown-item" href="#">Rename</a></li>
                                    <li><a class="dropdown-item" href="#">Block</a></li>
                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                </ul>
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
                        <a href="#" class="more-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu shadow border-0 p-2">
                            <li><a class="dropdown-item" href="#">File Info</a></li>
                            <li><a class="dropdown-item" href="#">Copy to</a></li>
                            <li><a class="dropdown-item" href="#">Move to</a></li>
                            <li><a class="dropdown-item" href="#">Rename</a></li>
                            <li><a class="dropdown-item" href="#">Block</a></li>
                            <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
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
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Eventchamp Speakers</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                        <a href="#" class="more-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu shadow border-0 p-2">
                            <li><a class="dropdown-item" href="#">File Info</a></li>
                            <li><a class="dropdown-item" href="#">Copy to</a></li>
                            <li><a class="dropdown-item" href="#">Move to</a></li>
                            <li><a class="dropdown-item" href="#">Rename</a></li>
                            <li><a class="dropdown-item" href="#">Block</a></li>
                            <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <img class="avatar rounded-circle" src="assets/img/xs/avatar2.jpg" alt="">
                        <div class="flex-fill ms-3">
                            <div class="h6 mb-0"><span>Chris Fox</span></div>
                            <small class="text-muted">UI UX Designer - NY USA</small>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <img class="avatar rounded-circle" src="assets/img/xs/avatar1.jpg" alt="">
                        <div class="flex-fill ms-3">
                            <div class="h6 mb-0"><span>Joge Lucky</span></div>
                            <small class="text-muted">UI UX Designer - NY USA</small>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <img class="avatar rounded-circle" src="assets/img/xs/avatar3.jpg" alt="">
                        <div class="flex-fill ms-3">
                            <div class="h6 mb-0"><span>Alexander</span></div>
                            <small class="text-muted">React Developer - NY USA</small>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <img class="avatar rounded-circle" src="assets/img/xs/avatar8.jpg" alt="">
                        <div class="flex-fill ms-3">
                            <div class="h6 mb-0"><span>Robert</span></div>
                            <small class="text-muted">Angular Master - NY USA</small>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <img class="avatar rounded-circle" src="assets/img/xs/avatar6.jpg" alt="">
                        <div class="flex-fill ms-3">
                            <div class="h6 mb-0"><span>Nellie</span></div>
                            <small class="text-muted">UI UX Designer - NY USA</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Recent Sells</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                        <a href="#" class="more-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu shadow border-0 p-2">
                            <li><a class="dropdown-item" href="#">File Info</a></li>
                            <li><a class="dropdown-item" href="#">Copy to</a></li>
                            <li><a class="dropdown-item" href="#">Move to</a></li>
                            <li><a class="dropdown-item" href="#">Rename</a></li>
                            <li><a class="dropdown-item" href="#">Block</a></li>
                            <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
                    </div>
                </div>
                <table id="myDataTable_no_filter" class="table align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Peoples</th>
                        <th>Venues</th>
                        <th>Seat</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>A0098</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/img/xs/avatar1.jpg" class="rounded-circle sm avatar" alt="">
                                <div class="ms-2 mb-0">Marshall Nichols</div>
                            </div>
                        </td>
                        <td>123 6th St. Melbourne, FL 32904</td>
                        <td>X1</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Video"><i class="fa fa-envelope"></i></button>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A0088</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/img/xs/avatar2.jpg" class="rounded-circle sm avatar" alt="">
                                <div class="ms-2 mb-0">Nellie Maxwell</div>
                            </div>
                        </td>
                        <td>4 Shirley Ave. West Chicago, IL 60185</td>
                        <td>X1</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Video"><i class="fa fa-envelope"></i></button>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A0067</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/img/xs/avatar3.jpg" class="rounded-circle sm avatar" alt="">
                                <div class="ms-2 mb-0">Chris Fox</div>
                            </div>
                        </td>
                        <td>70 Bowman St. South Windsor, CT 06074</td>
                        <td>X2</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Video"><i class="fa fa-envelope"></i></button>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A0045</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/img/xs/avatar1.jpg" class="rounded-circle sm avatar" alt="">
                                <div class="ms-2 mb-0">Marshall Nichols</div>
                            </div>
                        </td>
                        <td>123 6th St. Melbourne, FL 32904</td>
                        <td>X1</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Video"><i class="fa fa-envelope"></i></button>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A0067</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/img/xs/avatar8.jpg" class="rounded-circle sm avatar" alt="">
                                <div class="ms-2 mb-0">Chris Fox</div>
                            </div>
                        </td>
                        <td>70 Bowman St. South Windsor, CT 06074</td>
                        <td>X2</td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Video"><i class="fa fa-envelope"></i></button>
                            <button type="button" class="btn btn-link btn-sm text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Download"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
