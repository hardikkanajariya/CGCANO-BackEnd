@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Gallery Pictures</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('gallery')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('gallery.add')}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Select Gallery Pictures</label>
                        <input type="file" class="form-control form-control-lg" name="gallery[]" multiple required>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('gallery')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
