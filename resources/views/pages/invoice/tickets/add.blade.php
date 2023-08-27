@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Add Manual Invoice</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                        <a href="{{route('orders.ticket')}}" class="more-icon dropdown-toggle"><i
                                class="fa fa-mail-reply"></i></a>
                    </div>
                </div>
                <form action="{{route('orders.ticket.doAdd')}}" method="post" enctype="multipart/form-data"
                      class="card-body">
                    @csrf
                    <div class="col-sm-12">
                        <select class="form-control" name="user">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->fullname}} - {{$user->email}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label class="form-label">Event Ticket</label>
                        <select class="form-control" name="ticket" id="ticket" onchange="calculateTotal()">
                            @foreach($tickets as $ticket)
                                <option value="{{$ticket->id}}" data-price="{{$ticket->price}}">{{$ticket->event->title}} - ${{$ticket->price}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label class="form-label">Quantity</label>
                        <input id="quantity" type="text" class="form-control form-control-lg" placeholder="000" oninput="calculateTotal()"
                               name="quantity" value="{{old('quantity') ? old('quantity') : 1}}" required>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label class="form-label">Total Amount</label>
                        <input type="text" id="total_amount" readonly class="form-control form-control-lg"
                               placeholder="000" name="total" value="{{old('total') ? old('total') : 0}}" required>
                    </div>
                    <div class="col-sm-12 mt-2 p-4">
                        <div class="form-check">
                            <input class="form-check-input p-1" type="checkbox" value="1" name="status"
                                   @if(old('status')) checked @endif>
                            <label class="form-check-label" for="discount">Payment Status</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{route('orders.ticket')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script>
        function calculateTotal() {
            const select = document.getElementById('ticket');
            const quantityInput = document.getElementById('quantity');
            const totalAmountInput = document.getElementById('total_amount');

            // Get the selected option and its price
            const selectedOption = select.options[select.selectedIndex];
            const selectedPrice = parseFloat(selectedOption.getAttribute('data-price'));

            // Get the entered quantity
            const quantity = parseFloat(quantityInput.value) || 0;

            // Calculate total amount
            const totalAmount = selectedPrice * quantity;

            // Update the total amount input field
            totalAmountInput.value = isNaN(totalAmount) ? '' : `${totalAmount.toFixed(2)}`;
        }

        // Call calculateTotal initially to set the initial value
        calculateTotal();
    </script>
@endsection
