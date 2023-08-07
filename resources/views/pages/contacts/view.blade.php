@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Contact Requests</h6>
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
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contacts as $data)
                        <tr>
                            <td>#CGEVE-{{$data->id}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->subject}}</td>
                            <td>{{$data->message}}</td>
                            <td>
                                @if($data->is_read == 1)
                                    <span class="badge bg-success">Solved</span>
                                @else
                                    <span class="badge bg-primary">New</span>
                                @endif
                            </td>
                            <td>
                                @if(!$data->is_read)
                                    <a href="{{route('contact.read', [$data->id])}}" class="btn btn-sm btn-success">
                                        Mark as Read
                                    </a>
                                @else
                                    <a href="{{route('contact.unread', [$data->id])}}" class="btn btn-sm btn-success">
                                        Mark as UnRead
                                    </a>
                                @endif
                                <a href="{{route('contact.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
