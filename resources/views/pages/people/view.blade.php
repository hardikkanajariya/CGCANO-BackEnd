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
                    <th>Is Guest</th>
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
                                    <h6 class="ms-2 mb-0">{{$user->fullname}}</h6>
                                </div>
                            </td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->is_guest_account)
                                    <span class="badge bg-warning text-dark">Guest</span>
                                @else
                                    <span class="badge bg-success">Member</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('people.edit', [$user->id])}}" class="btn py-0 btn-link btn-sm text-muted"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Send invoice"><i
                                        class="fa fa-eye"></i></a>
                                <a href="{{route('people.edit', [$user->id])}}" class="btn py-0 btn-link btn-sm text-muted"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="{{route('people.edit', [$user->id])}}" class="btn py-0 btn-link btn-sm text-muted"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa fa-trash"></i></a>

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
                responsive: true
            });
        });
    </script>
@endsection