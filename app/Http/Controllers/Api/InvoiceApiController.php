<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barcodes;
use App\Models\InvoiceComboTicket;
use App\Models\InvoiceTicket;
use App\Models\Tickets;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Picqer\Barcode\BarcodeGeneratorPNG;


class InvoiceApiController extends Controller
{
    /* --------------- Function To Handle Invoice Status ------------------- */
    // Function to update order status
    public function updateOrderStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
        ]);

        // Update Order Status
        $order = InvoiceTicket::find($request->order_id);
        $order->status = $request->status;
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Order Status Updated Successfully',
            'order' => $order,
        ]);
    }
    /* --------------- Function To Insert Invoice Details ------------------- */
    // Function to Create Ticket order
    public function createTicketOrder(Request $request)
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
        $order = InvoiceTicket::create([
            'user_id' => $request->user_id,
            'ticket_id' => $request->ticket_id,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
            'is_paid' => false,
            'full_name' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Return the response
        return response()->json([
            'message' => 'Order Created Successfully',
            'order_id' => $order->id,
            'order' => $order,
            'ticket_price' => $ticket->price,
        ]);
    }

    // Function to Create Combo order
    public function createComboOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'nullable',
            'combo_id' => 'required|exists:combo_tickets,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric',
            'fullname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $order = new InvoiceComboTicket();
        $order->user_id = $request->user_id;
        $order->combo_id = $request->combo_id;
        $order->quantity = $request->quantity;
        $order->total_amount = $request->total_amount;
        $order->is_paid = false;
        $order->full_name = $request->fullname;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Order Created Successfully',
            'order_id' => $order->id,
            'order' => $order,
            'ticket_price' => $order->combo->price * $order->quantity,
        ]);
    }

    /* --------------- Function to Insert Payment Details ------------------- */
    // Function to Insert Payment Details for Ticket
    public function paymentDetailsTicket(Request $request)
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
        $order = InvoiceTicket::find($request->order_id);
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

        $barcodeImages = $this->generateBarcodes($order, $request);

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
        $pdf->loadHtml(View::make('pdf.invoice', compact('invoiceData', 'barcodeImages')));
        $pdf->setPaper('A4', 'horizontal'); // Set paper size and orientation
        $pdf->render();

        // Save the PDF to a public path or return as response
        $randomString = md5(rand(11111111, 99999999)); // Using md5 for URL-safe hash
        $pdfPath = public_path("invoices/$randomString.pdf"); // Change the path and filename as needed
        file_put_contents($pdfPath, $pdf->output());

        // Send Email To The User With Barcode Image Attached
        try {
//            if($order->user->email == $order->email) {
//                Mail::to($order->user->email)->send(new TicketEmail("invoices/$randomString.pdf", $order->user->fullname));
//            }else{
//                Mail::to($order->user->email)->send(new TicketEmail("invoices/$randomString.pdf", $order->user->fullname));
//                // Send Mail to order email
//                Mail::to($order->email)->send(new TicketEmail("invoices/$randomString.pdf", $order->user->fullname));
//            }
        } catch (Exception $e) {
            // return $e->getMessage();
        }
        // Update ticket quantity
        $quantity = $ticket->tickets_left - $order->quantity;
        if ($quantity <= 0) {
            $ticket->is_sold_out = true;
        }
        $ticket->tickets_left = $quantity < 0 ? 0 : $quantity;
        $ticket->save();

        // update invoice status
        $order->is_paid = true;
        $order->status = true;
        $order->pdf = $randomString . ".pdf";
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Payment Details Inserted Successfully',
            'order' => $order->load('payment')->payment,
        ]);
    }

    // Function to Insert Payment Details for Combo

    private function generateBarcodes($order, $request)
    {
        $barcodeImages = [];
        for ($i = 0; $i < $order->quantity; $i++) {
            // Generate Barcode (Code 128)
            $barcodeValue = "INV-" . $request->order_id . "-" . rand(1000, 9999) . "-" . rand(1000, 9999);

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

            $barcodeImages[] = $barcodeImage;
        }
        return $barcodeImages;
    }

    // Function to generate barcodes

    public function paymentDetailsCombo(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required',
//            'billing_token' => 'required',
//            'payment_amount' => 'required',
//            'facilitator_access_token' => 'nullable',
//            'paypal_order_id' => 'required',
//            'payer_id' => 'required',
//            'payer_name' => 'nullable',
//            'payer_email' => 'nullable',
//            'payer_address' => 'nullable',
//            'gross_amount' => 'required',
//            'status' => 'required',
        ]);

        // Insert Payment Details
        $order = InvoiceComboTicket::find($request->order_id);
//        $order->payment()->create([
//            'order_id' => $request->order_id,
//            'billing_token' => $request->billing_token,
//            'payment_amount' => $request->payment_amount,
//            'facilitator_access_token' => $request->facilitator_access_token,
//            'paypal_order_id' => $request->paypal_order_id,
//            'payer_id' => $request->payer_id,
//            'payer_name' => $request->payer_name,
//            'payer_email' => $request->payer_email,
//            'payer_address' => $request->payer_address,
//            'gross_amount' => $request->gross_amount,
//            'status' => $request->status,
//        ]);
        $combo = $order->combo;
        $ticket = $order->ticket;
        foreach (json_decode($ticket->event_id) as $ticket){
            $barcodeImages = $this->generateBarcodes($order, $request);

            // Get the ticket details
            $ticket = Tickets::where('event_id', $ticket)->first();

            $invoiceData = [
                'invoiceNumber' => "INV" . $request->order_id,
                'amount' => $request->total_price ? $request->total_price : $request->gross_amount,
                'name' => $order->user->fullname,
                'title' => $combo->name,
            ];

            $events = $ticket->event_id;
            $randomString = md5(rand(11111111, 99999999)); // Using md5 for URL-safe hash

            // Load the PDF template with data
            $pdf = new Dompdf();
            $pdf->loadHtml(View::make('pdf.combo', compact('invoiceData', 'events')));
            $pdf->setPaper('A4', 'horizontal'); // Set paper size and orientation
            $pdf->render();

            // Save the PDF to a public path or return as response
            $pdfPath = public_path("invoices/combo/$randomString.pdf"); // Change the path and filename as needed
            file_put_contents($pdfPath, $pdf->output());

            // Update ticket quantity
            $quantity = $ticket->tickets_left - $order->quantity;
            if ($quantity <= 0) {
                $ticket->is_sold_out = true;
            }
            $ticket->tickets_left = $quantity < 0 ? 0 : $quantity;
            $ticket->save();

            // update invoice status
            $order->is_paid = true;
            $order->status = true;
            $order->pdf = $randomString . ".pdf";
            $order->save();
        }
        // Return the response
        return response()->json([
            'message' => 'Payment Details Inserted Successfully',
            'order' => $order->load('payment')->payment,
        ]);
    }
}
