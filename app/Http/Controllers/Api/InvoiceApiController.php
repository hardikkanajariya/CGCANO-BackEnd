<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceComboMail;
use App\Mail\InvoiceTicketMail;
use App\Models\Barcodes;
use App\Models\ErrorLog;
use App\Models\EventList;
use App\Models\InvoiceCombo;
use App\Models\InvoicePackage;
use App\Models\InvoiceTicket;
use App\Models\TicketCombo;
use App\Models\TicketEvent;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Picqer\Barcode\BarcodeGeneratorPNG;


class InvoiceApiController extends Controller
{
    // Function to generate barcodes
    private function generateBarcodes($order, $request, $type, $valid_till, $is_food_available = false)
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
            Barcodes::create([
                'invoice_id' => $request->order_id,
                'barcode_id' => $barcodeValue,
                'barcode_img' => $barcodeValue . ".png",
                'type' => $type,
                'scan_remaining' => $order->quantity,
                'valid_till' => $valid_till ? $valid_till : date('Y-m-d H:i:s', strtotime('+1 day')),
                'is_food_available' => $is_food_available,
            ]);

            $barcodeImages[] = $barcodeImage;
        }
        return $barcodeImages;
    }

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
            'user_id' => 'nullable|exists:users,id', // Made nullable for guest users
            'order_id' => 'nullable',
            'ticket_id' => 'required|exists:tickets_event,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric',
            'fullname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'is_guest' => 'nullable|boolean', // New field for guest identification
        ]);

        // check if ticket is available or not
        $ticket = TicketEvent::find($request->ticket_id);
        if ($ticket->is_sold_out) {
            return response()->json([
                'message' => 'Ticket is not available',
            ], 400);
        }

        // Handle guest user creation if needed
        $userId = $request->user_id;
        if (!$userId && $request->is_guest) {
            // Create guest user account
            $guestController = new \App\Http\Controllers\Api\GuestUserController();
            $guestRequest = new Request([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'mobile' => $request->phone,
                'user_id' => $request->user_id
            ]);

            $guestResponse = $guestController->createGuestUser($guestRequest);
            $guestData = json_decode($guestResponse->getContent(), true);

            if ($guestResponse->getStatusCode() !== 201 && $guestResponse->getStatusCode() !== 200) {
                return response()->json([
                    'message' => 'Failed to create guest account',
                    'error' => $guestData['message'] ?? 'Unknown error'
                ], 500);
            }

            $userId = $guestData['user_id'];
        }

        // Create Order
        $order = InvoiceTicket::create([
            'user_id' => $userId,
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
            'user_id' => 'nullable|exists:users,id', // Made nullable for guest users
            'is_guest' => 'nullable|boolean',
            'order_id' => 'nullable',
            'combo_id' => 'required|exists:tickets_combo,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric',
            'fullname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // get the combo details
        $combo = TicketCombo::find($request->combo_id);
        if ($combo->status == 0) {
            return response()->json([
                'message' => 'Combo is not available',
            ], 400);
        }

        // check if the combo is not sold out and is active
        $events = json_decode($combo->event_id);
        foreach ($events as $event) {
            $event = TicketEvent::where("event_id", $event)->first();
            if ($event->is_sold_out == 1 || $event->is_active == 0) {
                return response()->json([
                    'message' => 'Combo is not available',
                ], 400);
            }
        }


        // Handle guest user creation if needed
        $userId = $request->user_id;
        if (!$userId && $request->is_guest) {
            // Create guest user account
            $guestController = new \App\Http\Controllers\Api\GuestUserController();
            $guestRequest = new Request([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'mobile' => $request->phone,
                'user_id' => $request->user_id
            ]);

            $guestResponse = $guestController->createGuestUser($guestRequest);
            $guestData = json_decode($guestResponse->getContent(), true);

            if ($guestResponse->getStatusCode() !== 201 && $guestResponse->getStatusCode() !== 200) {
                return response()->json([
                    'message' => 'Failed to create guest account',
                    'error' => $guestData['message'] ?? 'Unknown error'
                ], 500);
            }

            $userId = $guestData['user_id'];
        }

        $order = new InvoiceCombo();
        $order->user_id = $userId;
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
            'ticket_price' => $order->ticket->price * $order->quantity,
        ]);
    }

    // Function to Create Package Order
    public function createPackageOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'nullable',
            'package_id' => 'required|exists:memberships,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric',
            'fullname' => 'required|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $order = new InvoicePackage();
        $order->user_id = $request->user_id;
        $order->package_id = $request->package_id;
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
            'ticket_price' => $request->total_amount,
            'name' => $order->package->name,
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

        // Get the ticket details
        $ticket = TicketEvent::find($order->ticket_id);

        // Get the event details
        $event = $ticket->event;

        // Generate Barcodes
        $barcodeImages = $this->generateBarcodes($order, $request, 'ticket', $event->end, $ticket->is_food_available);

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
        // update invoice status
        $order->is_paid = true;
        $order->status = true;
        $order->pdf = $randomString . ".pdf";
        $order->save();
        // Send Email To The User With Barcode Image Attached
        try {
            if ($order->user->email == $order->email) {
                Mail::to($order->user->email)->send(new InvoiceTicketMail("invoices/$randomString.pdf", $order->user->fullname));
            } else {
                Mail::to($order->email)->cc($order->user->email)->send(new InvoiceTicketMail("invoices/$randomString.pdf", $order->user->fullname));
            }
        } catch (Exception $e) {
            $log = new ErrorLog();
            $log->type = "Package Invoice Email Sending";
            $log->message = $e->getMessage();
            $log->save();
        }
        // Update ticket quantity
        $quantity = $ticket->tickets_left - $order->quantity;
        if ($quantity <= 0) {
            $ticket->is_sold_out = true;
        }
        $ticket->tickets_left = $quantity < 0 ? 0 : $quantity;
        $ticket->save();

        // Return the response
        return response()->json([
            'message' => 'Payment Successfully Done',
            'order' => $order->load('payment')->payment,
        ]);
    }

    // Function to Insert Payment Details for Combo
    public function paymentDetailsCombo(Request $request)
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
        $order = InvoiceCombo::find($request->order_id);
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

        $pdf = new Dompdf();
        $pdf->setPaper('A4', 'horizontal'); // Set paper size and orientation
        $invoiceData = [
            "order_id" => $order->id,
            "Name" => $order->name,
            "quantity" => $order->quantity,
            "total_amount" => $order->total_amount,
            "fullname" => $order->full_name,
            "email" => $order->email,
            "phone" => $order->phone,
        ];
        $randomString = md5(rand(11111111, 99999999)); // Using md5 for URL-safe hash

        // Load the PDF template with data
        $pdf->loadHtml(View::make('pdf.combo', compact('invoiceData',)));
        $pdf->render();

        // Save the PDF to a public path or return as response
        $pdfPath = public_path("invoices/combo/$randomString.pdf"); // Change the path and filename as needed
        file_put_contents($pdfPath, $pdf->output());

        // Send Email To The User With Barcode Image Attached
        try {
            if ($order->user->email == $order->email) {
                Mail::to($order->user->email)->send(new InvoiceComboMail($order->id));
            } else {
                Mail::to($order->email)->cc($order->user->email)->send(new InvoiceComboMail($order->id));
            }
        } catch (Exception $e) {
            $log = new ErrorLog();
            $log->type = "Package Invoice Email Sending";
            $log->message = $e->getMessage();
            $log->save();
        }

        // update combo invoice status
        $order->is_paid = true;
        $order->status = true;
        $order->pdf = $randomString . ".pdf";
        $order->save();

        $combo_ticket = $order->ticket;
        foreach (json_decode($combo_ticket->event_id) as $event) {
            $event = EventList::find($event);
            $ticket = TicketEvent::where('event_id', $event->id)->first();
            // Create Order
            $ticket_order = InvoiceTicket::create([
                'user_id' => $order->user_id,
                'ticket_id' => $ticket->id,
                'quantity' => $order->quantity,
                'total_amount' => $order->total_amount,
                'is_paid' => false,
                'full_name' => $order->full_name,
                'email' => $order->email,
                'phone' => $order->phone,
            ]);

            $barcodeImages = $this->generateBarcodes($order, $request, 'combo', $event->end, $ticket->is_food_available);

            $ticket = TicketEvent::where('event_id', $event->id)->first();

            $invoiceData = [
                'invoiceNumber' => "INV" . $request->order_id,
                'amount' => $request->total_price ? $request->total_price : $request->gross_amount,
                'name' => $order->user->fullname,
                'time' => $event->start,
                'title' => $event->title,
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

            // Update ticket quantity
            $quantity = $ticket->tickets_left - $order->quantity;
            if ($quantity <= 0) {
                $ticket->is_sold_out = true;
            }
            $ticket->tickets_left = $quantity < 0 ? 0 : $quantity;
            $ticket->save();

            // update invoice status
            $ticket_order->is_paid = true;
            $ticket_order->status = true;
            $ticket_order->pdf = $randomString . ".pdf";
            $ticket_order->save();
        }
        // Return the response
        return response()->json([
            'message' => 'Payment Successfully Done',
            'order' => $order->load('payment')->payment,
        ]);
    }

    // Function to Insert Payment Details for Package
    public function paymentDetailsPackage(Request $request)
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
        $order = InvoicePackage::find($request->order_id);
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

        $pdf = new Dompdf();
        $pdf->setPaper('A4', 'horizontal'); // Set paper size and orientation
        $invoiceData = [
            "order_id" => $order->id,
            "Name" => $order->name,
            "total_amount" => $order->total_amount,
            "fullname" => $order->full_name,
            "email" => $order->email,
            "phone" => $order->phone,
            'package_name' => $order->package->name,
        ];
        $randomString = md5(rand(11111111, 99999999)); // Using md5 for URL-safe hash

        // Load the PDF template with data
        $pdf->loadHtml(View::make('pdf.package', compact('invoiceData',)));
        $pdf->render();

        // Save the PDF to a public path or return as response
        $pdfPath = public_path("invoices/package/$randomString.pdf"); // Change
        file_put_contents($pdfPath, $pdf->output());

        // Send Email To The User With Barcode Image Attached
        try {
            if ($order->user->email == $order->email) {
                Mail::to($order->user->email)->send(new InvoiceComboMail($order->id));
            } else {
                Mail::to($order->email)->cc($order->user->email)->send(new InvoiceComboMail($order->id));
            }
        } catch (Exception $e) {
            $log = new ErrorLog();
            $log->type = "Package Invoice Email Sending";
            $log->message = $e->getMessage();
            $log->save();
        }

        // update combo invoice status
        $order->is_paid = true;
        $order->status = true;
        $order->pdf = $randomString . ".pdf";
        $order->validity = date('Y-m-d H:i:s', strtotime($order->package->validity));
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Payment Details Inserted Successfully',
            'order' => $order->load('payment')->payment,
        ]);
    }
}
