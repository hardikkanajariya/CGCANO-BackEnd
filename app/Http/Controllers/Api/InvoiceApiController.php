<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TicketEmail;
use App\Models\Barcodes;
use App\Models\Invoice;
use App\Models\Tickets;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;


class InvoiceApiController extends Controller
{
    // Function to Create Order
    public function createOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'nullable',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric',
            'fullname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // check if ticket is available or not
        $ticket = Tickets::find($request->ticket_id);
        if ($ticket->is_sold_out) {
            return response()->json([
                'message' => 'Ticket is not available',
            ], 400);
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
            'order' => $order,
            'ticket_price' => $ticket->price,
        ]);
    }

    // Function to validate order id
    public function validateOrder($id)
    {
        // Find order by order_id
        $order = Invoice::find($id);

        // If order not found then return the response
        if (!$order) {
            return response()->json([
                'message' => 'Order Not Found',
            ], 404);
        }

        // Return the response
        return response()->json([
            'message' => 'Order Found',
            'order' => $order,
        ]);
    }

    // Function to update order status
    public function updateOrderStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
        ]);

        // Update Order Status
        $order = Invoice::find($request->order_id);
        $order->status = $request->status;
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
            'billing_token' => 'required',
            'payment_amount' => 'required',
            'facilitator_access_token' => 'nullable',
            'paypal_order_id' => 'required',
            'payer_id' => 'required',
            'payer_name' => 'nullable',
            'payer_email' => 'nullable',
            'payer_address' => 'nullable',
            'gross_amount' => 'required',
            'status' => 'required',
        ]);

        // Insert Payment Details
        $order = Invoice::find($request->order_id);
        $order->payment()->create([
            'order_id' => $request->order_id,
            'billing_token' => $request->billing_token,
            'payment_amount' => $request->payment_amount,
            'facilitator_access_token' => $request->facilitator_access_token,
            'paypal_order_id' => $request->paypal_order_id,
            'payer_id' => $request->payer_id,
            'payer_name' => $request->payer_name,
            'payer_email' => $request->payer_email,
            'payer_address' => $request->payer_address,
            'gross_amount' => $request->gross_amount,
            'status' => $request->status,
        ]);

        $barcodeValue = "INV-" . $request->order_id . "-" . rand(1000, 9999);

        // Create a BarcodeGenerator instance for PNG images
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcodeImage = $barcodeGenerator->getBarcode($barcodeValue, $barcodeGenerator::TYPE_CODE_128);

        // save barcode image
        $barcodePath = public_path("barcodes/$barcodeValue.png");
        file_put_contents($barcodePath, $barcodeImage);

        // Insert Barcode Details
        $barcode = Barcodes::create([
            'invoice_id' => $request->order_id,
            'barcode_id' => $barcodeValue,
            'barcode_img' => $barcodeValue . ".png",
        ]);

        // Get the ticket details
        $ticket = Tickets::find($order->ticket_id);

        // Get the event details
        $event = $ticket->event;

        $invoiceData = [
            'invoiceNumber' => "INV" . $request->order_id,
            'amount' => $request->total_price ? $request->total_price : $request->gross_amount,
            'name' => $order->user->fullname,
            'time' => $event->start,
            'title' => $order->ticket->event->title,
        ];

        // Load the PDF template with data
        $pdf = new Dompdf();
        $pdf->loadHtml(View::make('pdf.invoice', compact('invoiceData', 'barcodeImage')));
        $pdf->setPaper('A4', 'horizontal'); // Set paper size and orientation
        $pdf->render();

        // Save the PDF to a public path or return as response
        $randomString = md5($barcodeValue); // Using md5 for URL-safe hash
        $pdfPath = public_path("invoices/$randomString.pdf"); // Change the path and filename as needed
        file_put_contents($pdfPath, $pdf->output());

        // Get the fullname
        $fullname = $order->user->fullname;

        // Send Email To The User With Barcode Image Attached
        try {
            Mail::to($order->user->email)->send(new TicketEmail("invoices/$randomString.pdf", $fullname));
        } catch (\Exception $e) {
            // Do Something
        }
        // Update ticket quantity
        $ticket = Tickets::find($order->ticket_id);
        $quantity = $ticket->tickets_left - $order->quantity;
        if ($quantity <= 0) {
            $ticket->is_sold_out = true;
        }
        $ticket->tickets_left = $quantity < 0 ? 0 : $quantity;
        $ticket->save();

        // update invoice status
        $order->is_paid = true;
        $order->status = "1";
        $order->pdf = $randomString . ".pdf";
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Payment Details Inserted Successfully',
            'order' => $order->load('payment')->payment,
        ]);
    }
}
