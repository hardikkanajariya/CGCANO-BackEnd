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
                    <div class="alert alert-info mt-3">
                        <strong>Note:</strong> If you don't see any event category, please add event category first.
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Select Event Category</label>
                        <select name="category_id" class="form-control form-control-lg" required>
                            <option value="">Select Event Category</option>
                            @foreach($categoryItems as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 mt-4">
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
