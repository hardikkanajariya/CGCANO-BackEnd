@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Edit Combo Ticket</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('ticket.combo')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('ticket.combo.doEdit', [$ticket->id])}}" method="post"
                      enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Events</label>
                        <select class=".select2 form-select" name="events[]" required multiple>
                            @foreach($events as $data)
                                @if(in_array(old('events'), json_decode($ticket->event_id)))
                                    <option value="{{$data->id}}" selected>{{$data->title}}</option>
                                    @continue
                                @elseif(in_array($data->id, json_decode($ticket->event_id)))
                                    <option value="{{$data->id}}" selected>{{$data->title}}</option>
                                    @continue
                                @else
                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="Enter Combo Ticket title"
                               name="name" value="{{old('name') ? old('name') : $ticket->name}}">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="description" placeholder="Please type what you want...">{{old('description')? old('description') : $ticket->description}}</textarea>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file" class="form-control form-control-lg" name="image">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Price</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="$299" name="price"
                               value="{{old('price') ? old('price') : $ticket->price}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Available Tickets</label>
                        <input type="number" required class="form-control form-control-lg" placeholder="99"
                               name="quantity" value="{{old('quantity')? old('quantity') : $ticket->quantity}}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-light-primary">Update</button>
                        <a href="{{route('event')}}" class="btn btn-light-secondary">Cancel</a>
{{--                        <a href="{{route('ticket.combo.markAsSold', [$ticket->id])}}" class="btn btn-light-warning">Mark as--}}
{{--                            Sold</a>--}}
                        <a href="{{route('ticket.combo.delete', [$ticket->id])}}" class="btn btn-light-danger"
                           onclick="confirm('Are you sure?')">Delete Ticket</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
