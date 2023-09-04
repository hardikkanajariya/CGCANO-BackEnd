@php use App\Models\Scanner; @endphp
@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title m-0">View Barcodes</h6>
                <div class="dropdown morphing scale-left">
                    <a href="#" class="card-fullscreen btn" style="width: 100px" data-bs-toggle="tooltip"
                       title="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
                    <a href="{{route('orders.ticket.add')}}" class="btn btn-outline-primary" style="width: 100px"><i
                            class="fa fa-add"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table id="myTable" class="table myDataTable table-hover align-middle mb-0 card-table">
                    <thead>
                    <tr>
                        <th>#Barcode Id</th>
                        <th>Image</th>
                        <th>Food</th>
                        <th>Ticket Scan</th>
                        <th>Food Scan</th>
                        <th>Food Scanned By</th>
                        <th>Ticket Scanned By</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($barcodes as $data)
                        <tr>
                            <td>{{$data->barcode_id}}</td>
                            <td>
                                <image src="{{url('/')}}/barcodes/{{$data->barcode_img}}" width="300px" height="50px">
                            </td>
                            <td>
                                @if($data->is_food_available == 0)
                                    <span class="badge bg-warning">No</span>
                                @elseif($data->is_food_available == 1)
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                            <td>
                                @if($data->is_used == 0)
                                    <span class="badge bg-warning">No</span>
                                @elseif($data->is_used == 1)
                                    <span class="badge bg-success">Used</span>
                                @endif
                            </td>
                            <td>
                                @if($data->is_food_taken == 0)
                                    <span class="badge bg-warning">No</span>
                                @elseif($data->is_food_taken == 1)
                                    <span class="badge bg-success">Yes</span>
                                @endif
                            </td>
                            <td>
                                @php $food_scanned_by = Scanner::where('id',$data->food_scanned_by)->first(); @endphp
                                @if($food_scanned_by)
                                    {{$food_scanned_by->name}}
                                @else
                                    <span class="badge bg-danger">Not Scanned</span>
                                @endif
                            </td>
                            <td>
                                @php $food_scanned_by = Scanner::where('id',$data->scanned_by)->first(); @endphp
                                @if($food_scanned_by)
                                    {{$food_scanned_by->name}}
                                @else
                                    <span class="badge bg-danger">Not Scanned</span>
                                @endif
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
