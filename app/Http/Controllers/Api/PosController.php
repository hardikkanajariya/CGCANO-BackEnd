<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceTicketMail;
use App\Models\Barcodes;
use App\Models\ErrorLog;
use App\Models\InvoiceTicket;
use App\Models\POSData;
use App\Models\TicketEvent;
use App\Models\User;
use Dompdf\Dompdf;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PosController extends Controller
{
    // Function to Authentication Volunteer
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $pos = POSData::where('email', $request->email)->first();

        if (!$pos || !Hash::check($request->password, $pos->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        } else {
            $token = $pos->createToken('pos-token');

            $response = [
                'pos' => $pos,
                'token' => $token
            ];

            return response($response, 201);
        }
    }

    // Function to get all tickets
    public function getTickets()
    {
        // Use the 'with' method to eager load the 'event' relation
        $tickets = TicketEvent::with('event')
            ->where('is_active', 1)
            ->get();

        return response($tickets, 200);
    }

    // Function to Sell Ticket
    public function sellTicket(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:volunteers,id',
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'ticket' => 'required|exists:tickets_event,id',
            'quantity' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:1'
        ]);

        // Create user if not exists in the database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'mobile' => $request->phone,
                'password' => Hash::make('12345678'),
                'created_by' => $request->user_id,
            ]);
        }

        // Get the User Details
        $user = User::find($user->id);
        $ticket = TicketEvent::find($request->ticket);

        if (!$user || !$ticket) {
            return response([
                'message' => ['User or Ticket not found']
            ], 404);
        }

        try {
            // Generating Invoice Order
            $invoice = new InvoiceTicket();
            $invoice->user_id = $user->id;
            $invoice->ticket_id = $request->ticket;
            $invoice->full_name = $user->fullname;
            $invoice->email = $user->email;
            $invoice->phone = $user->phone;
            $invoice->quantity = $request->quantity;
            $invoice->total_amount = $request->total;
            $invoice->is_paid = true;
            $invoice->status = true;
            $invoice->sold_by = $request->user_id;
            $invoice->save();

            // Get the ticket details
            $ticket = TicketEvent::find($request->ticket);

            // Get the event details
            $event = $ticket->event;

            // Generate Barcodes
            $barcodeImages = $this->generateBarcodes($invoice, $event->end);

            $invoiceData = [
                'invoiceNumber' => "INV" . $request->order_id,
                'amount' => $request->total,
                'name' => $invoice->user->fullname,
                'time' => $event->start,
                'title' => $ticket->event->title,
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
            $quantity = $ticket->tickets_left - $invoice->quantity;
            if ($quantity <= 0) {
                $ticket->is_sold_out = true;
            }
            $ticket->tickets_left = $quantity < 0 ? 0 : $quantity;
            $ticket->save();

            // update invoice status
            $invoice->pdf = $randomString . ".pdf";
            $invoice->save();
            // Send Email To The User With Barcode Image Attached
            try {
                Mail::to($user->email)->send(new InvoiceTicketMail("invoices/$randomString.pdf", $user->fullname));
            } catch (Exception $e) {
                $log = new ErrorLog();
                $log->type = "Manual Ticket Invoice Email Sending";
                $log->message = $e->getMessage();
                $log->save();
            }
            return response([
                'status' => 'success',
                'message' => 'Ticket Sold Successfully'
            ], 201);
        } catch (Exception $e) {
            $log = new ErrorLog();
            $log->type = 'Manual Ticket invoice Generation';
            $log->message = $e->getMessage();
            $log->save();
            return response([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    // Function to get Sold Tickets

    private function generateBarcodes($order, $valid_till)
    {
        try {
            $barcodeImages = [];
            for ($i = 0; $i < $order->quantity; $i++) {
                // Generate Barcode (Code 128)
                $barcodeValue = "INV-" . $order->id . "-" . rand(1000, 9999) . "-" . rand(1000, 9999);

                // Create a BarcodeGenerator instance for PNG images
                $barcodeGenerator = new BarcodeGeneratorPNG();
                $barcodeImage = $barcodeGenerator->getBarcode($barcodeValue, $barcodeGenerator::TYPE_CODE_128);

                // save barcode image
                $barcodePath = public_path("barcodes/$barcodeValue.png");
                file_put_contents($barcodePath, $barcodeImage);

                // Insert Barcode Details
                $barcode = Barcodes::create([
                    'invoice_id' => $order->id,
                    'barcode_id' => $barcodeValue,
                    'barcode_img' => $barcodeValue . ".png",
                    'type' => 'ticket',
                    'scan_remaining' => $order->quantity,
                    'valid_till' => $valid_till ? $valid_till : date('Y-m-d H:i:s', strtotime('+1 day')),
                ]);

                $barcodeImages[] = $barcodeImage;
            }
            return $barcodeImages;
        } catch (Exception $e) {
            $log = new ErrorLog();
            $log->type = 'Manual Ticket Barcode Generation';
            $log->message = $e->getMessage();
            $log->save();
            return response([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    // Function to generate Barcodes

    public function getSoldTickets(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:volunteers,id'
        ]);

        $tickets = InvoiceTicket::with('ticket.event')
            ->where('sold_by', $request->user_id)
            ->where('status', 1)
            ->get();

        return response($tickets, 200);
    }

}
