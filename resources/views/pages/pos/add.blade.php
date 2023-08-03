@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New POS Credentials</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('pos')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('pos.add')}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Volunteer Name</label>
                        <input type="text" max="15" class="form-control form-control-lg" placeholder="john doe" required
                               name="name">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Username</label>
                        <input name="username" type="text" max="15" class="form-control form-control-lg"
                               placeholder="@johndoe"
                               required>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control form-control-lg"
                               placeholder="john@mail.com"
                               required>
                    </div>
                    <div class="col-sm-12 ">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control form-control-lg">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Confirm Password</label>
                        <input name="confirm_password" type="text" class="form-control form-control-lg"
                               placeholder="Enter your Password"
                               required>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <href href="{{route('pos')}}" class="btn btn-secondary">Cancel</href>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
