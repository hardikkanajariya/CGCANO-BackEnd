@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Edit Membership Package</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('membership')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('membership.doEdit', [$package->id])}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Package Name</label>
                        <input type="text" class="form-control form-control-lg" placeholder="GOLD" required name="name" value="{{old('name') ? old('nmae') : $package->name}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="description" placeholder="Please type what you want...">{{old('description') ? old('description') : $package->description}}</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control form-control-lg" placeholder="$99xx" name="price" value="{{old('price') ? old('price') : $package->price}}" required>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{route('membership')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
