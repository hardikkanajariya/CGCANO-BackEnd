@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{url('/')}}/assets/css/summernote.min.css"/>
@endsection

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Event</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('event')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('event.add')}}" method="post" enctype="multipart/form-data" class="card-body needs-validation" novalidate="" data-parsley-validate>
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control form-control-lg" required name="title" value="{{old('title')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control form-control-lg" name="slug" value="{{old('slug')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="description" placeholder="Please type what you want...">{{old('description')}}</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category" required>
                            @foreach($categories as $data)
                                <option value="{{$data->id}}" {{old('category') == $data->id ? "selected" : ""}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 ">
                        <label class="form-label">Venue</label>
                        <select class="form-select" name="venue" required>
                            @foreach($venues as $data)
                                <option value="{{$data->id}}" {{old('venue') == $data->id ? "selected" : ""}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 ">
                        <label class="form-label">Speaker</label>
                        <select class="form-select" name="speaker" required>
                            @foreach($speakers as $data)
                                <option value="{{$data->id}}" {{old('speaker') == $data->id ? "selected" : ""}}>{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control form-control-lg" required id="start" name="start" value="{{old('start')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control form-control-lg" required id="end" name="end" value="{{old('end')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Duration</label>
                        <input type="text" class="form-control form-control-lg" required readonly id="duration" name="duration" value="{{old('duration')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control form-control-lg" required name="thumbnail">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Gallery</label>
                        <input type="file" class="form-control form-control-lg" multiple name="gallery[]">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Ticket Available</label>
                        <input type="number" class="form-control form-control-lg" required name="tickets_available" value="{{old('tickets_available')}}" placeholder="Number of tickets available to purchase">
                    </div>
{{--                    <div class="col-sm-12 mt-3">--}}
{{--                        <label class="form-label">Allowed Audiences &nbsp;&nbsp;&nbsp;&nbsp;</label>--}}
{{--                        <div class="form-check form-check-inline">--}}
{{--                            <label class="form-check-label" for="flexCheckDefault">Adults</label>--}}
{{--                            <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="audience_type[]" required="" data-parsley-errors-container="#error-checkbox">--}}
{{--                        </div>--}}
{{--                        <div class="form-check form-check-inline">--}}
{{--                            <label class="form-check-label" for="flexCheckDefault2">Family</label>--}}
{{--                            <input class="form-check-input" type="checkbox" id="flexCheckDefault2" name="audience_type[]">--}}
{{--                        </div>--}}
{{--                        <div class="form-check form-check-inline">--}}
{{--                            <label class="form-check-label" for="flexCheckDefault3">Group</label>--}}
{{--                            <input class="form-check-input" type="checkbox" id="flexCheckDefault3" name="audience_type[]">--}}
{{--                        </div>--}}
{{--                        <div class="form-check form-check-inline">--}}
{{--                            <label class="form-check-label" for="flexCheckDefault3">Children</label>--}}
{{--                            <input class="form-check-input" type="checkbox" id="flexCheckDefault3" name="audience_type[]">--}}
{{--                        </div>--}}
{{--                        <div class="form-check form-check-inline">--}}
{{--                            <label class="form-check-label" for="flexCheckDefault3">Youth</label>--}}
{{--                            <input class="form-check-input" type="checkbox" id="flexCheckDefault3" name="audience_type[]">--}}
{{--                        </div>--}}
{{--                        <p id="error-checkbox"></p>--}}
{{--                    </div>--}}
                    <div class="col-sm-12">
                        <label class="form-label">Youtube Video URL</label>
                        <input type="url" class="form-control form-control-lg" name="youtube" value="{{old('youtube')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Facebook</label>
                        <input type="url" class="form-control form-control-lg" name="facebook" value="{{old('facebook')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Instagram</label>
                        <input type="url" class="form-control form-control-lg" name="instagram" value="{{old('instagram')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Twitter</label>
                        <input type="url" class="form-control form-control-lg" name="twitter" value="{{old('twitter')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">LinkedIn</label>
                        <input type="url" class="form-control form-control-lg" name="linkedin" value="{{old('linkedin')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Website</label>
                        <input type="url" class="form-control form-control-lg" name="website" value="{{old('website')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Contact Phone</label>
                        <input type="tel" class="form-control form-control-lg" name="phone" required value="{{old('phone')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" required value="{{old('email')}}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('event')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <!-- Jquery Validation Plugin Js -->
    <!-- Jquery Page Js -->
    <script>
        $(document).ready(function () {

            // default value
            $("#duration").val("0 seconds");
            // for start and End
            // current date and time
            const now = new Date();
            // set current date and time to start date and time
            $("#start").val(now.toISOString().slice(0, 16));
            // set current date and time to end date and time
            $("#end").val(now.toISOString().slice(0, 16));
            // for start and end date time change event
            $("#start, #end").on("change", function () {
                calculateDuration();
            });
        });
        function calculateDuration() {
            const startDateTimeInput = $("#start").val();
            const endDateTimeInput = $("#end").val();

            const startDateTime = new Date(startDateTimeInput);
            const endDateTime = new Date(endDateTimeInput);

            const durationMs = endDateTime - startDateTime;
            if (durationMs < 0) {
                $("#duration").val("End date-time should be after start date-time.");
                return;
            }

            let durationString = '';

            const days = Math.floor(durationMs / (1000 * 60 * 60 * 24));
            durationString += days > 0 ? days + ' day' + (days === 1 ? ' ' : 's ') : '';

            const hours = Math.floor((durationMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            durationString += hours > 0 ? hours + ' hour' + (hours === 1 ? ' ' : 's ') : '';

            const minutes = Math.floor((durationMs % (1000 * 60 * 60)) / (1000 * 60));
            durationString += minutes > 0 ? minutes + ' minute' + (minutes === 1 ? ' ' : 's ') : '';

            const seconds = Math.floor((durationMs % (1000 * 60)) / 1000);
            durationString += seconds > 0 ? seconds + ' second' + (seconds === 1 ? ' ' : 's ') : '';

            $("#duration").val(durationString.trim() || '0 seconds');
        }
    </script>
@endsection
