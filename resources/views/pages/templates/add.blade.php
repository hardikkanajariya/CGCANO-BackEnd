@extends('layouts.main')
@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Email Template</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('settings.email')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('settings.email.doAdd')}}" method="post" enctype="multipart/form-data" class="card-body needs-validation" novalidate="" data-parsley-validate>
                    @csrf
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Events</label>
                        <select class="form-select" name="event_id" required>
                            @foreach($events as $data)
                                <option value="{{$data->id}}">{{$data->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="Enter Combo Ticket title"
                               name="subject" value="{{old('subject')}}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Body</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="body" placeholder="Please type what you want...">{{old('body')}}</textarea>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Flyer</label>
                        <input type="file" class="form-control form-control-lg" required name="image">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('settings.email')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
