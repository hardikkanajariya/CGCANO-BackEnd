@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Edit Event Ticket for <span class="text-bg-warning p-2">{{$event->title}}</span></h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('event')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('ticket.doEdit', [$ticket->id])}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Price</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="$299" name="price" value="{{old('price') ? old('price') : $ticket->price}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Available Tickets</label>
                        <input type="number" required class="form-control form-control-lg" placeholder="99" name="quantity" value="{{old('quantity')? old('quantity') : $ticket->quantity}}">
                    </div>
                    <div  class="col-sm-12">
                        <label class="form-label">Food Available</label>
                        <select name="food" class="form-control form-control-lg" name="food" required>
                            <option @if($ticket->food) selected @endif value="1">Yes</option>
                            <option @if($ticket->food) selected @endif value="0">No</option>
                        </select>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-light-primary">Update</button>
                        <a href="{{route('event')}}" class="btn btn-light-secondary">Cancel</a>
{{--                        <a href="{{route('ticket.markAsSold', [$ticket->id])}}" class="btn btn-light-warning">Mark as Sold</a>--}}
                        <a href="{{route('ticket.delete', [$ticket->id])}}" class="btn btn-light-danger" onclick="confirm('Are you sure?')">Delete Ticket</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
