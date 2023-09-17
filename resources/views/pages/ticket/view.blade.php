@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Event Tickets</h6>
{{--                <div class="dropdown morphing scale-left">--}}
{{--                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"--}}
{{--                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>--}}
{{--                    <a href="{{route('ticket')}}" class="btn btn-outline-primary" style="width: auto"><i class="fa fa-add mx-2"></i>Add Combo Ticket</a>--}}
{{--                </div>--}}
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Tickets Sold</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{$data->event->title}}</td>
                            <td>{{$data->price}}</td>
                            <td>{{$data->quantity}}</td>
                            <td>{{$data->ticketsSold()}}</td>
                            <td>
                                @if($data->is_sold_out == 0)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Sold Out</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('ticket.edit', [$data->id])}}" class="btn btn-sm btn-success"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{route('ticket.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
