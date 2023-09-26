@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Edit Template</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('settings.email')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('settings.email.doEdit', [$template->id])}}" method="post" enctype="multipart/form-data" class="card-body needs-validation" novalidate="" data-parsley-validate>
                    @csrf
                    <input type="hidden" name="id" value="{{$template->id}}">
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control form-control-lg" required name="title" value="{{old('title') ? old('title') : $template->title}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Description</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="description" placeholder="Please type what you want...">{{old('description') ? old('description') : $template->description}}</textarea>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control form-control-lg" name="thumbnail">
                        @if($template->thumbnail)
                            <img src="{{url('/')}}/images/event/thumbnail/{{$template->thumbnail}}" alt="{{$template->thumbnail}}" class="img-fluid rounded-4">
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Gallery</label>
                        <input type="file" class="form-control form-control-lg" multiple name="gallery[]">
                        <div class="row g-2" data-masonry='{ "percentPosition": "true" }'>
                            @if($template->gallery == null)
                                @foreach(json_decode($template->gallery) as $item)
                                    <div class="col grid-item">
                                        <img class="img-fluid rounded-4" src="{{url('/')}}/images/event/gallery/{{$item}}" alt="{{$item}}" >
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Ticket Email Flyer</label>
                        <input type="file" class="form-control form-control-lg" name="flyer">
                        @if($template->flyer)
                            <img class="img-fluid rounded-4" src="{{url('/')}}/flyer/{{$template->flyer}}" alt="{{$template->flyer}}">
                        @endif
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Youtube Video URL</label>
                        <input type="url" class="form-control form-control-lg" name="youtube" value="{{old('youtube') ? old('youtube') : $template->youtube}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Facebook</label>
                        <input type="url" class="form-control form-control-lg" name="facebook" value="{{old('facebook') ? old('facebook') : $template->facebook}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Instagram</label>
                        <input type="url" class="form-control form-control-lg" name="instagram" value="{{old('instagram') ? old('instagram') : $template->instagram}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Twitter</label>
                        <input type="url" class="form-control form-control-lg" name="twitter" value="{{old('twitter') ? old('twitter') : $template->twitter}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">LinkedIn</label>
                        <input type="url" class="form-control form-control-lg" name="linkedin" value="{{old('linkedin') ? old('linkedin') : $template->linkedin}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Website</label>
                        <input type="url" class="form-control form-control-lg" name="website" value="{{old('website') ? old('website') : $template->website}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Contact Phone</label>
                        <input type="tel" class="form-control form-control-lg" name="phone" required value="{{old('phone') ? old('phone') : $template->contact_phone}}">
                    </div>
                    <div class="col-sm-12 mb-2">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" required value="{{old('email') ? old('email') : $template->contact_email}}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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

            // // default value
            // $("#duration").val("0 seconds");
            // // for start and End
            // const now = new Date();
            // // set current date and time to start date and time
            // $("#start").val(now.toISOString().slice(0, 16));
            // // set current date and time to end date and time
            // $("#end").val(now.toISOString().slice(0, 16));
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
