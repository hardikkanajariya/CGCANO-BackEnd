@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Volunteer</h6>
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
                        <input type="text" class="form-control form-control-lg" placeholder="john doe" required value="{{old('name')}}"
                               name="name">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Phone</label>
                        <input name="phone" type="number" class="form-control form-control-lg"
                               placeholder="Enter your Phone Number" value="{{old('phone')}}"
                               required>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control form-control-lg"
                               placeholder="john@mail.com" value="{{old('email')}}"
                               required>
                    </div>
                    <div class="col-sm-12 ">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control form-control-lg" value="{{old('password')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Confirm Password</label>
                        <input name="confirm_password" type="text" class="form-control form-control-lg"
                               placeholder="Generate Password"
                               required>
                    </div>
                    <div class="col-sm-12 mt-2 p-4">
                        <div class="form-check">
                            <input class="form-check-input p-1" type="checkbox" value="1" id="discount" name="status" @if(old('status')) checked @endif>
                            <label class="form-check-label" for="discount">Status</label>
                        </div>
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
