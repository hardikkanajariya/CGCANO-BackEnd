<?php

namespace App\Http\Controllers;

use App\Mail\TicketEmail;
use App\Models\InvoiceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MiscellaneousController extends Controller
{
    // Function to resend the Invoice Email
    public function resendInvoiceEmail($id)
    {
        // Get the invoice
        $invoice = InvoiceTicket::find($id);

        // Send the email
//        Mail::to($invoice->email)->send(new TicketEmail("invoices/{$invoice->pdf}", $invoice->full_name));
        return redirect()->back()->with('success', 'Invoice Email Sent Successfully');
    }
}
