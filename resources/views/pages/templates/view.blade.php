@extends('layouts.main')

@section("content")
<div class="row g-3 row-deck">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title m-0">Event Mail Templates</h6>
            <div class="dropdown morphing scale-left">
                <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                    title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                <a href="{{route('settings.email.add')}}" class="btn btn-outline-primary" style="width: 100px"><i
                        class="fa fa-add"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                <thead>
                    <tr>
                        <th>#Id</th>
                        <th>Event Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @php
                $i = 1;
                @endphp
                    @foreach($templates as $data)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$data->event->title}}</td>
                        <td>
                            <a href="{{route('settings.email.edit', [$data->id])}}" class="btn btn-sm btn-success"><i
                                    class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('page-scripts')
<script>
    $(document).ready(function () {
            $('#myTable').addClass('nowrap').dataTable({
                responsive: true,
            });
        });
</script>
@endsection
