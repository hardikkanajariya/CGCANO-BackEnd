@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Scanner Credentials</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('scanner')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('scanner.edit', [$scanner->id])}}" method="post" enctype="multipart/form-data"
                      class="card-body">
                    @csrf
                    <input type="hidden" name="id" value="{{$scanner->id}}">
                    <div class="col-sm-12">
                        <label class="form-label">Scanner Name</label>
                        <input type="text" class="form-control form-control-lg" placeholder="john doe" required value="{{$scanner->name}}"
                               name="name">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">fullname</label>
                        <input type="text" name="fullname" class="form-control form-control-lg"
                               value="{{$scanner->fullname}}" required>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                               value="{{$scanner->email}}" required>
                    </div>
                    <div class="mb-2 ">
                        <label class="form-label">Old Password</label>
                        <input type="password" name="old_password" class="form-control form-control-lg">
                    </div>
                    <div class="mb-2 ">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Confirm Password</label>
                        <input type="text" class="form-control form-control-lg" placeholder="Enter your Password"
                               name="password_confirmation">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{route('scanner')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
