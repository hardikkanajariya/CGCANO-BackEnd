@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Subscribers</h6>
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
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subscribed as $data)
                        <tr>
                            <td>#CGEVE-{{$data->id}}</td>
                            <td>{{$data->email}}</td>
                            <td>
                                @if($data->status == 1)
                                    <span class="badge bg-success">Subscribed</span>
                                @else
                                    <span class="badge bg-danger">Unsubscribed</span>
                                @endif
                            </td>
                            <td>
                                @if(!$data->status)
                                    <a href="{{route('sub.true', [$data->id])}}" class="btn btn-sm btn-success">
                                        Subscribe
                                    </a>
                                @else
                                    <a href="{{route('sub.false', [$data->id])}}" class="btn btn-sm btn-success">
                                        Unsubscribe
                                    </a>
                                @endif
                                <a href="{{route('sub.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
