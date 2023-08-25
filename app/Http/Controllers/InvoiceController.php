<?php

namespace App\Http\Controllers;

use App\Models\InvoiceCombo;
use App\Models\InvoiceDonation;
use App\Models\InvoicePackage;
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
