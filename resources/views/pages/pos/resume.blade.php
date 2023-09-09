@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Volunteers Resume Requests</h6>
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->address}}</td>
                            <td>{{$data->message}}</td>
                            <td>
                                @if($data->status == "Pending")
                                    <span class="badge  bg-info text-white">New</span>
                                @elseif($data->status == "Approved")
                                    <span class="badge  bg-success text-white">Approved</span>
                                @elseif($data->status == "Rejected")
                                    <span class="badge  bg-danger text-white">Rejected</span>
                                @else
                                    <span class="badge  bg-secondary text-white">Unknown</span>
                                @endif
                            </td>
                            <td>
                                @if($data->status == "Pending")
                                    <a href="{{route('pos.resume.approve', [$data->id])}}" onclick="confirm('By Approving this status please make sure you have created Volunteers Credentials and Informed.')" class="btn btn-sm btn-success"><i
                                            class="fa fa-check"></i>&nbsp;&nbsp;Approve</a>
                                    <a href="{{route('pos.resume.reject', [$data->id])}}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-times"></i>&nbsp;&nbsp;Reject</a>
                                @elseif($data->status == "Approved")
                                    <a href="{{route('pos.resume.reject', [$data->id])}}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-times"></i>&nbsp;&nbsp;Reject</a>

                                @elseif($data->status == "Rejected")
                                    <a href="{{route('pos.resume.approve', [$data->id])}}" onclick="confirm('By Approving this status please make sure you have created Volunteers Credentials and Informed.')"  class="btn btn-sm btn-success"><i
                                            class="fa fa-check"></i>&nbsp;&nbsp;Approve</a>
                                    <a href="{{route('pos.resume.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></a>
                                @else
                                    <a href="{{route('pos.resume.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-trash"></i></a>
                                @endif
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
