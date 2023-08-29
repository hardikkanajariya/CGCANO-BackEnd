@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Membership Invoice </h6>
                <div class="dropdown morphing scale-left">
                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>#Id</th>
                        <th>user</th>
                        <th>Package</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->user->fullname}}</td>
                            <td>{{$data->package->name}}</td>
                            <td>{{$data->total_amount}}</td>
                            <td>
                                @if($data->status == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($data->status == 1)
                                    <span class="badge bg-success">Completed</span>
                                @elseif($data->status == 2)
                                    <span class="badge bg-danger">Cancelled</span>
                                @elseif($data->status == 3)
                                    <span class="badge bg-secondary">Failed</span>
                                @elseif($data->status == 4)
                                    <span class="badge bg-danger">UnPublished</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('payment.package',[$data->id])}}"
                                   class="btn btn-sm btn-outline-success">Payment</a>
                                <a href="{{route('orders.package.delete', ["id" => $data->id])}}" class="btn btn-sm btn-outline-danger">Cancel
                                </a>
                            </td>
                        </tr>
                    @endforeach
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
