@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex align-items-center flex-column flex-md-row">
                    <img src="{{$user->img}}" alt="" class="rounded" style="width: 210px;">
                    <div class="ms-md-5 m-0 mt-4 mt-md-0 text-md-start text-center">
                        <h5 class="fw-boldSmith <span class=" text-danger="" small"="">#{{$user->id}}</h5>
                        <p><strong>Name:</strong> {{$user->fullname}}</p>
                        <p><strong>Address:</strong> {{$user->address}}</p>
                        <div class="d-flex justify-content-center align-items-center mb-3 mt-2">
                            <div class="me-3 me-md-5">
                                <small class="text-muted">Date of Birth</small>
                                <div class="mb-0 fw-bold">{{$user->dob}}</div>
                            </div>
                            <div class="me-3 me-md-5">
                                <small class="text-muted">Phone</small>
                                <div class="mb-0 fw-bold">{{$user->mobile}}</div>
                            </div>
                            <div class="me-3 me-md-5">
                                <small class="text-muted">Email ID</small>
                                <div class="mb-0 fw-bold">{{$user->email}}</div>
                            </div>
                        </div>
                        <a href="{{route('people')}}" class="btn btn-primary btn-sm px-4">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
