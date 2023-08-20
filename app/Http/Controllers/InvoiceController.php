<?php

namespace App\Http\Controllers;

use App\Models\InvoiceTicket;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Function to view All Invoices
    public function list(){
        $invoices = InvoiceTicket::all();
        return view('pages.invoice.tickets.view', compact('invoices'));
    }

    public function viewPayment($id)
    {
        // Get the payment Details from InvoiceTicket ID
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

    // Function to view Edit InvoiceTicket
    public function edit($id){
        return redirect()->route('orders');
    }

    // Function to view Delete InvoiceTicket
    public function delete($id){
        return redirect()->route('orders');
    }
}
