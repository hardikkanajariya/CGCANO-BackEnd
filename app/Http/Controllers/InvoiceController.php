<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceTicketMail;
use App\Models\Barcodes;
use App\Models\ErrorLog;
use App\Models\InvoiceCombo;
use App\Models\InvoiceDonation;
use App\Models\InvoicePackage;
use App\Models\InvoiceTicket;
use App\Models\TicketEvent;
use App\Models\User;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Picqer\Barcode\BarcodeGeneratorPNG;

class InvoiceController extends Controller
{
    // Function to generate barcodes
    public function listTicket()
    {
        $invoices = InvoiceTicket::all();
        return view('pages.invoice.tickets.view', compact('invoices'));
    }
    /* --------------- Function To Handle Ticket Invoice ------------------- */
    // Function to view All InvoiceTicket

    public function viewTicketPayment($id)
    {
        // Get the payment details from either InvoiceTicket or InvoiceCombo ID
        $invoice = InvoiceTicket::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'InvoiceTicket not found');
        }

        $paymentDetails = $invoice->payment;
        if (!$paymentDetails) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        return view('pages.invoice.tickets.payment', compact('paymentDetails'));
    }

    public function viewAddManualTicketInvoice()
    {
        $users = User::all();
        $tickets = TicketEvent::where('is_sold_out', '0')->where('is_active', '1')->get();
        $data = compact('users', 'tickets');
        return view('pages.invoice.tickets.add')->with($data);
    }

    // Function to Add Manual Invoice Ticket

    public function doAddManualTicketInvoice(Request $request)
    {
        $request->validate([
            'user' => 'required|exists:users,id',
            'ticket' => 'required|exists:tickets_event,id',
            'quantity' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:1'
        ]);

        // Get the User Details
        $user = User::find($request->user);
        $ticket = TicketEvent::find($request->ticket);

        if (!$user || !$ticket) {
            return redirect()->back()->with('error', 'User or Ticket not found');
        }

        try {
            // Generating Invoice Order
            $invoice = new InvoiceTicket();
            $invoice->user_id = $request->user;
            $invoice->ticket_id = $request->ticket;
            $invoice->full_name = $user->name;
            $invoice->email = $user->email;
            $invoice->phone = $user->phone;
            $invoice->quantity = $request->quantity;
            $invoice->total_amount = $request->total;
            $invoice->is_paid = $request->status ? true : false;
            $invoice->status = $request->status ? true : false;
            $invoice->save();

            // Get the ticket details
            $ticket = TicketEvent::find($request->ticket);

            // Get the event details
            $event = $ticket->event;

            // Generate Barcodes
            $barcodeImages = $this->generateBarcodes($invoice, 'ticket', $event->end);

            $invoiceData = [
                'invoiceNumber' => "INV" . $request->order_id,
                'amount' => $request->total_price ? $request->total_price : $request->gross_amount,
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
            return redirect()->route('orders.ticket')->with('success', 'InvoiceTicket Added Successfully');
        } catch (Exception $e) {
            $log = new ErrorLog();
            $log->type = 'Manual Ticket invoice Generation';
            $log->message = $e->getMessage();
            $log->save();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to Do Add Manual Invoice Ticket

    private function generateBarcodes($order, $type, $valid_till)
    {
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
                'type' => $type,
                'scan_remaining' => $order->quantity,
                'valid_till' => $valid_till ? $valid_till : date('Y-m-d H:i:s', strtotime('+1 day')),
            ]);

            $barcodeImages[] = $barcodeImage;
        }
        return $barcodeImages;
    }

    /* --------------- Function To Handle Combo Invoice ------------------- */
    // Combo Invoice List

    public function listCombo()
    {
        $invoices = InvoiceCombo::all();
        return view('pages.invoice.combo.view', compact('invoices'));
    }

    // Combo Invoice Payment
    public function viewPaymentCombo($id)
    {
        // Get the payment Details from InvoiceTicket ID
        $invoice = InvoiceCombo::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'InvoiceTicket not found');
        }
        $paymentDetails = $invoice->payment;
        if (!$paymentDetails) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        return view('pages.invoice.combo.payment', compact('paymentDetails'));
    }

    /* --------------- Function To Handle Package Invoice ------------------- */

    public function listPackage()
    {
        $invoices = InvoicePackage::all();
        return view('pages.invoice.package.view', compact('invoices'));
    }

    public function viewPaymentPackage($id)
    {
        // Get the payment Details from InvoiceTicket ID
        $invoice = InvoicePackage::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }
        $paymentDetails = $invoice->payment;
        if (!$paymentDetails) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        return view('pages.invoice.package.payment', compact('paymentDetails'));
    }

    /* --------------- Function To Handle Donation Invoice ------------------- */

    public function listDonation()
    {
        $invoices = InvoiceDonation::all();
        return view('pages.invoice.donation.view', compact('invoices'));
    }

    public function viewPaymentDonation($id)
    {
        // Get the payment Details from InvoiceTicket ID
        $invoice = InvoiceDonation::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }
        $paymentDetails = $invoice->payment;
        if (!$paymentDetails) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        return view('pages.invoice.donation.payment', compact('paymentDetails'));
    }
}
