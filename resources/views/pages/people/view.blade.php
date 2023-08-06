@extends('layouts.main')

@section("content")
    <div class="col">
        <table id="myDataTable_no_filter" class="table custom-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>EVE-{{$user->id}}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{$user->img}}" class="rounded-circle sm avatar" alt="">
                            <h6 class="ms-2 mb-0">{{$user->first_name}} {{$user->last_name}}</h6>
                        </div>
                    </td>
                    <td>{{$user->mobile}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->address}}</td>
                    <td>
                        <button type="button" class="btn py-0 btn-link btn-sm text-muted" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Send invoice"><i class="fa fa-envelope"></i></button>
                        <button type="button" class="btn py-0 btn-link btn-sm text-muted" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Download"><i class="fa fa-download"></i></button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('#myDataTable_no_filter').addClass('nowrap').dataTable({
                responsive: true,
            });
        });
    </script>
@endsection
