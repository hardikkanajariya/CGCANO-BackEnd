@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">POS Credentials</h6>
                <div class="dropdown morphing scale-left">
                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                    <a href="{{route('pos.add')}}" class="btn btn-outline-primary" style="width: 100px"><i class="fa fa-add"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="{{route('pos.edit', [1])}}" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="{{route('pos.edit', [1])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>John Smith</td>
                        <td>#2122109</td>
                        <td>01-05-2020</td>
                        <td><span class="badge  bg-success text-white">Paid</span></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('#myTable').addClass('nowrap').dataTable({
                responsive: true,
            });
        });
    </script>
@endsection
