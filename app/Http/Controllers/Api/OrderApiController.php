<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    // Function to Create Order
    public function createOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'event_id' => 'required',
            'ticket_id' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ]);

        // Create Order
        $order = Orders::create([
            'event_id' => $request->event_id,
            'ticket_id' => $request->ticket_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Return the response
        return response()->json([
            'message' => 'Order Created Successfully',
            'order' => $order,
        ]);
    }

    // Function to Insert Payment Details
    public function paymentDetails(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required',
            'payment_method' => 'required',
            'payment_status' => 'required',
            'payment_details' => 'required',
        ]);

        // Insert Payment Details
        $order = Orders::find($request->order_id);
        $order->payment()->create([
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'payment_details' => $request->payment_details,
        ]);

        // Return the response
        return response()->json([
            'message' => 'Payment Details Inserted Successfully',
            'order' => $order,
        ]);
    }
}
