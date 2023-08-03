@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Edit Speaker</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('speaker')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('speaker.edit', [$speaker->id])}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Name</label>
                        <input type="text" max="15" class="form-control form-control-lg" placeholder="@johndoe"
                               name="name" value="{{old('name') ? old('name') : $speaker->name}}" required>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control form-control-lg" placeholder="Speaker" name="title"
                               required value="{{old('title') ? old('title') : $speaker->title}}">
                    </div>
                    <div class="col-sm-12 ">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control form-control-lg" name="image">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Website</label>
                        <input type="url" class="form-control form-control-lg" placeholder="www.example.com"
                               name="website" value="{{old('website') ? old('website') : $speaker->website}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea rows="4" class="form-control no-resize" name="description"
                                  placeholder="Please type what you want...">{{old('description') ? old('description') : $speaker->description}}</textarea>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <href href="{{route('speaker')}}" class="btn btn-secondary">Cancel</href>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
