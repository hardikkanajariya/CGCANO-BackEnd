@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add New Product</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                        <a href="#" class="more-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu shadow border-0 p-2">
                            <li><a class="dropdown-item" href="#">File Info</a></li>
                            <li><a class="dropdown-item" href="#">Copy to</a></li>
                            <li><a class="dropdown-item" href="#">Move to</a></li>
                            <li><a class="dropdown-item" href="#">Rename</a></li>
                            <li><a class="dropdown-item" href="#">Block</a></li>
                            <li><a class="dropdown-item" href="#">Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <label class="form-label">Product SKU*</label>
                            <input type="text" class="form-control form-control-lg" placeholder="#2255">
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Name">
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Quantity</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Enter here">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Purchase Price</label>
                            <input type="number" class="form-control form-control-lg" placeholder="$12.29">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Retail Price</label>
                            <input type="number" class="form-control form-control-lg" placeholder="$18.99">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Brand</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Nike">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Manufacture</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Nike India">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Category</label>
                            <select class="form-control form-control-lg" tabindex="-98">
                                <option value="">- Category -</option>
                                <option value="10">Cloths</option>
                                <option value="20">Electronics</option>
                                <option value="30">Home Appliance</option>
                                <option value="40">Mobile</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Package Dimensions</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Length in Inches">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">&nbsp;</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Width in Inches">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">&nbsp;</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Height in Inches">
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">Upload Product Images</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label">Product Description</label>
                            <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
