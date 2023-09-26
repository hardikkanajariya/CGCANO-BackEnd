@extends('layouts.main')

@section('head')
    <style>
        .image-fluid {
            width: 150px;
            height: 150px;
            object-fit: cover;
            overflow: hidden;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
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
                       title="Card Full-Screen"><i class="fas fa-expand-arrows-alt"></i></a>
                    <a href="{{ route('gallery.add') }}" class="btn btn-outline-primary" style="width: 100px"><i
                            class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body" style="height: auto !important;">
                @foreach($categories as $category)
                    <h4>{{ $category['name'] }}</h4>
                    <div class="grid mb-5">
                        @foreach($galleryItems as $item)
                            @if($item->category_id == $category['id'])
                                <div class="col-md-3">
                                    <div class="item">
                                        <a href="{{ route('gallery.delete', [$item->id]) }}"
                                           class="badge bg-danger position-relative"
                                           style="z-index: 1;top:29px; right: -5px;">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <img class="image-fluid rounded-4"
                                             src="{{ url('/') }}/images/gallery/{{ $item->path }}"
                                             alt="{{ $item->category->name }}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
@endsection
