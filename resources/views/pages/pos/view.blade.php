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
                        <th>fullname</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pos as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>#POS-{{$data->id}}</td>
                            <td>{{\Illuminate\Support\Facades\Date::make($data->created_at)}}</td>
                            <td>
                                @if($data->status)
                                    <span class="badge  bg-success text-white">Active</span>
                                @else
                                    <span class="badge  bg-danger text-white">Blocked</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('pos.edit', [$data->id])}}" class="btn btn-sm btn-success"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{route('pos.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i
                                        class="fa fa-trash"></i></a>
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
