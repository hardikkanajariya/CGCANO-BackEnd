@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Combo Tickets Invoice</h6>
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
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->user->fullname}}</td>
                            <td>{{$data->quantity}}</td>
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
                                <a href="{{route('payment.combo',[$data->id])}}"
                                   class="btn btn-sm btn-outline-success">View Payment Details</a>
                            </td>
                            <td>
                                <ul>
                                    <li>Full Name: {{$data->full_name}}</li>
                                    <li>Email: {{$data->email}}</li>
                                    <li>Phone: {{$data->phone}}</li>
                                    <li>View Ticket:
                                        <a href="{{url('/')}}/invoices/combo/{{$data->pdf}}">View Ticket</a>
                                    </li>
                                    <li>Resent Invoice:
                                        <a href="{{route('resend.combo', ["id" => $data->id])}}">Resend</a>
                                    </li>
                                    <li>
                                        <form action="{{route('orders.combo.delete', ["id" => $data->id])}}"
                                              method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Cancel
                                            </button>
                                        </form>
                                    </li>
                                </ul>
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
