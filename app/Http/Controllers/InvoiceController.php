<?php

namespace App\Http\Controllers;

use App\Models\InvoiceComboTicket;
use App\Models\InvoiceTicket;

class InvoiceController extends Controller
{
    /* --------------- Function To Handle Ticket Invoice ------------------- */
    // Function to view All InvoiceTicket
    public function listTicket()
    {
        $invoices = InvoiceTicket::all();
        return view('pages.invoice.tickets.view', compact('invoices'));
    }

    public function viewTicketPayment($id)
    {
        // Get the payment details from either InvoiceTicket or InvoiceComboTicket ID
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

    /* --------------- Function To Handle Combo Invoice ------------------- */
    // Combo Invoice List
    public function listCombo()
    {
        $invoices = InvoiceComboTicket::all();
        return view('pages.invoice.combo.view', compact('invoices'));
    }

    // Combo Invoice Payment
    public function viewPaymentCombo($id)
    {
        // Get the payment Details from InvoiceTicket ID
        $invoice = InvoiceComboTicket::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'InvoiceTicket not found');
        }
        $paymentDetails = $invoice->payment;
        if (!$paymentDetails) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        return view('pages.invoice.combo.payment', compact('paymentDetails'));
    }

    // Combo Invoice Payment

    // Combo Invoice Delete

    /* --------------- Function To Handle Package Invoice ------------------- */

    /* --------------- Function To Handle Donation Invoice ------------------- */
}
