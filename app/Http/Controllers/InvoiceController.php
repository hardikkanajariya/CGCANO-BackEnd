<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Function to view All Invoices
    public function list(){
        $invoices = Invoice::all();
        return view('pages.invoice.view', compact('invoices'));
    }

    public function viewPayment($id)
    {
        // Get the payment Details from Invoice ID
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice not found');
        }
        $paymentDetails = $invoice->payment;
        if (!$paymentDetails) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        return view('pages.invoice.payment', compact('paymentDetails'));
    }

    // Function to view Edit Invoice
    public function edit($id){
        return redirect()->route('orders');
    }

    // Function to view Delete Invoice
    public function delete($id){
        return redirect()->route('orders');
    }
}
