<?php

namespace App\Http\Controllers;

use App\Mail\ComboInvoice;
use App\Mail\TicketEmail;
use App\Models\InvoiceCombo;
use App\Models\InvoiceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MiscellaneousController extends Controller
{
    // Function to resend the Invoice Email for Ticket
    public function resendInvoiceEmail(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:invoice_ticket,id',
        ]);

        // Get the invoice
        $invoice = InvoiceTicket::find($request->id);

        // Send the email
        try{
            Mail::to($invoice->email)->cc($invoice->user->email)->send(new TicketEmail("invoices/{$invoice->pdf}", $invoice->full_name));
            return redirect()->back()->with('success', 'Invoice Email Sent Successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    // Function to resend the Invoice Email for Combo
    public function resendInvoiceEmailCombo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:invoice_combo,id',
        ]);

        // Get the invoice
        $invoice = InvoiceCombo::find($request->id);

        // Send the email
        try{
            Mail::to($invoice->email)->cc($invoice->user->email)->send(new ComboInvoice($invoice->id));
            return redirect()->back()->with('success', 'Invoice Email Sent Successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
