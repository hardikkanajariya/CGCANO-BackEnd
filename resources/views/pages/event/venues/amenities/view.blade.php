@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Amenities</h6>
                <div class="dropdown morphing scale-left">
                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                    <a href="{{route('event.venue.amenities.add')}}" class="btn btn-outline-primary" data-toggle="modal" data-target="#addEventCategoryModal" style="width: 100px"><i class="fa fa-add"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>#Id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($amenities as $data)
                            <tr>
                                <td>#Id-{{$data->id}}</td>
                                <td>{{$data->name}}</td>
                                <td>
                                    <img src="{{url('/images/event/venue/amenities/'.$data->image)}}" alt="" width="50px" height="50px">
                                </td>
                                <td>
                                    <a href="{{route('event.venue.amenities.edit', [$data->id])}}" class="btn btn-sm btn-success"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="{{route('event.venue.amenities.delete', [$data->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
