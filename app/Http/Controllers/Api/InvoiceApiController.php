<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    // Function to Create Order
    public function createOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'nullable',
            'user_id' => 'nullable',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric|min:1',
            'username' => 'required|min:3|max:255|alpha_dash',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required|',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country_code' => 'required',
        ]);

        // check if order_id is already exists or not if exists then return the response
        if ($request->order_id != null) {
            $order = Invoice::find($request->order_id);
            if ($order) {
                return response()->json([
                    'message' => 'Order Already Exists',
                    'order' => $order,
                ]);
            }
        }

        // check if user_id is null
        if ($request->user_id == null) {
            // Find user by email
            $user = User::where('email', $request->email)->first();
            // If user not found then create new user
            if (!$user) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'mobile' => $request->phone,
                    'address' => $request->address,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'country_code' => $request->country_code,
                    'password' => \Hash::make('password'),
                ]);
            }
            // Assign user_id
            $request->user_id = $user->id;
        }

        // Create Order
        $order = Invoice::create([
            'user_id' => $request->user_id,
            'ticket_id' => $request->ticket_id,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
            'is_paid' => false,
        ]);

        // Return the response
        return response()->json([
            'message' => 'Order Created Successfully',
            'order_id' => $order->id,
        ]);
    }

    // Function to update order status
    public function updateOrderStatus($status, Request $request){
        // Validate the request
        $request->validate([
            'order_id' => 'required',
        ]);

        // Update Order Status
        $order = Invoice::find($request->order_id);
        $order->is_paid = $status;
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Order Status Updated Successfully',
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
        $order = Invoice::find($request->order_id);
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
