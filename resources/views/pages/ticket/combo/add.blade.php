@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Combo Ticket</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('event')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('ticket.combo.doAdd')}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Events</label>
                        <select class="form-select" name="events[]" required multiple>
                            @foreach($events as $data)
                                <option value="{{$data->id}}" {{old('events') == $data->id ? "selected" : ""}}>{{$data->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="Enter Combo Ticket title"
                               name="name" value="{{old('name')}}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="description" placeholder="Please type what you want...">{{old('description')}}</textarea>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control form-control-lg" required name="image">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="$99X"
                               name="price" value="{{old('price')}}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Available Tickets</label>
                        <input type="number" required class="form-control form-control-lg" placeholder="X"
                               name="quantity" value="{{old('quantity')}}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('ticket.combo')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
