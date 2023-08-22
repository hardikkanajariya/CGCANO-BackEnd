@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Event Ticket for <span class="text-bg-warning p-2">{{$event->title}}</span></h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('event')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('ticket.add', [$event->slug])}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Price</label>
                        <input type="text" required class="form-control form-control-lg" placeholder="$99X"
                               name="price" value="{{old('price')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Available Tickets</label>
                        <input type="number" required class="form-control form-control-lg" placeholder="X"
                               name="quantity" value="{{old('quantity')}}">
                    </div>
                    <div  class="col-sm-12">
                        <label class="form-label">Food Available</label>
                        <select name="food" class="form-control form-control-lg" name="food" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
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
@endsection
