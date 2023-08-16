@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Event Venue</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('event.venues')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('event.venue.edit', [$venue->id])}}" method="post" enctype="multipart/form-data"
                      class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Venue Name</label>
                        <input type="text" class="form-control form-control-lg"
                               placeholder="Enter Category name" name="name" required value="{{old('name') ?old('name') : $venue->name}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea rows="4" class="form-control no-resize" name="description"
                                  placeholder="Please type what you want...">{{old('description') ?old('description') : $venue->description}}</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Address</label>
                        <textarea rows="4" class="form-control no-resize" name="address"
                                  placeholder="Please type what you want...">{{old('address') ?old('address') : $venue->address}}</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control form-control-lg" placeholder="Enter city" name="city" required value="{{old('city') ? old('city'): $venue->city}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control form-control-lg"
                               placeholder="Enter Category name" name="state" required value="{{old('state') ?old('state') : $venue->state}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control form-control-lg"
                               placeholder="Enter Category name" name="country" required value="{{old('country') ?old('country') : $venue->country}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control form-control-lg"
                               placeholder="Enter Category name" name="zip_code" required value="{{old('zip_code') ?old('zip_code') : $venue->postal_code}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Amenities</label>
                        <select name="amenities[]" class="form-control show-tick ms select2" multiple="" data-placeholder="Select">
                            @foreach($amenities as $amenity)
                                <option value="{{$amenity->id}}">{{$amenity->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{route('event.venues')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
