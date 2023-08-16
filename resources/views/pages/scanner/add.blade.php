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
                <form action="{{route('scanner.add')}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Scanner Name</label>
                        <input type="text" class="form-control form-control-lg" placeholder="john doe" required
                               name="name">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" placeholder="@johndoe"
                               name="username"
                               required>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control form-control-lg" placeholder="john@mail.com"
                               name="email"
                               required>
                    </div>
                    <div class="col-sm-12 ">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" name="password">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Confirm Password</label>
                        <input type="text" class="form-control form-control-lg" placeholder="Enter your Password"
                               name="password_confirmation"
                               required>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('scanner')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
