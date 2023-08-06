@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Events</h6>
                <div class="dropdown morphing scale-left">
                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                    <a href="{{route('event.add')}}" class="btn btn-outline-primary" style="width: 100px"><i class="fa fa-add"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>#Id</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Speaker</th>
                        <th>Tickets</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $data)
                        <tr>
                            <td>#CGEVE-{{$data->id}}</td>
                            <td>{{$data->title}}</td>
                            <td>{{$data->start}} to {{$data->end}}</td>
                            <td>{{$data->venue->address}}</td>
                            <td>
                                <span class="badge bg-success text-white">{{$data->title}}</span>
                            </td>
                            <td>43/{{$data->tickets_available}}</td>
                            <td><span class="badge  bg-success text-white">Ticket Available</span></td>
                            <td>
                                <a href="{{route('event.edit', [$data->id])}}" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                                <a href="{{route('event.edit', [$data->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
