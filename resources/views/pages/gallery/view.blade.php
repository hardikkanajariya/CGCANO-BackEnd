@extends('layouts.main')

@section('head')
    <style>
        .image-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 10px;
        }

        .item {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

    </style>
@endsection

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">Memories</h6>
                <div class="dropdown morphing scale-left">
                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                    <a href="{{route('gallery.add')}}" class="btn btn-outline-primary" style="width: 100px"><i
                            class="fa fa-add"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="grid">
                    @foreach($galleryItems as $item)
                        <div class="item">
                            <a href="{{route('gallery.delete', [$item->id])}}" class="badge bg-danger position-relative" style="z-index: 1;top:29px; right: -5px;">
                                <i class="fa fa-trash"></i>
                            </a>
                            <img class="image-fluid rounded-4" src="{{$item->path}}" alt="{{$item->path}}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
@endsection
