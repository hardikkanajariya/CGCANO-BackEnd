@extends('layouts.main')

@section("content")
    <div class="row g-3 row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title m-0">Invoice Payment Details</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Payment Information</h5>
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <td>{{ $paymentDetails->id }}</td>
                            </tr>
                            <tr>
                                <th>Order ID</th>
                                <td>{{ $paymentDetails->order_id }}</td>
                            </tr>
                            <tr>
                                <th>Billing Token</th>
                                <td>{{ $paymentDetails->billing_token }}</td>
                            </tr>
                            <!-- Add other payment details here -->
                        </table>
                    </div>

                    <div class="mb-4">
                        <h5>Payer Information</h5>
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td>{{ $paymentDetails->payer_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $paymentDetails->payer_email }}</td>
                            </tr>
                            <!-- Add other payer details here -->
                        </table>
                    </div>

                    <div class="mb-4">
                        <h5>Payment Amount</h5>
                        <p>{{ $paymentDetails->payment_amount }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Status</h5>
                        <p>{{ $paymentDetails->status }}</p>
                    </div>
                    <div class="mb-4">
                        <h5>Created At</h5>
                        <p>{{ $paymentDetails->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
@endsection
