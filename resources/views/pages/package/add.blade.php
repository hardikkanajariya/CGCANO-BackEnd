@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Membership</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('membership')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('membership.doAdd')}}" method="post" enctype="multipart/form-data" class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <label class="form-label">Package Name</label>
                        <input type="text" class="form-control form-control-lg" placeholder="GOLD" required name="name" value="{{old('name')}}">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea id="summernote" rows="10" class="form-control no-resize" name="description" placeholder="Please type what you want...">{{old('description')}}</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control form-control-lg" placeholder="$99xx" name="price" value="{{old('price')}}" required>
                    </div>
                    <div class="col-sm-12 p-4">
                        <div class="form-check">
                            <input class="form-check-input p-1" type="checkbox" value="1" id="discount" onchange="toggleDiscount()" name="discount" @if(old('discount')) checked @endif>
                            <label class="form-check-label" for="discount">Discount</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Percentage</label>
                        <input id="percentage" type="text" class="form-control form-control-lg" placeholder="100%" disabled name="percentage" value="{{old('percentage')}}">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('membership')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script>
    function toggleDiscount() {
        // using vanilla javascript
        const element = document.getElementById('percentage');
        if (element.hasAttribute('disabled')) {
            element.removeAttribute('disabled');
        } else {
            element.setAttribute('disabled', '');
        }
    }
    </script>
@endsection
