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

    public function viewPayment()
    {
        return view('pages.invoice.payment');
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
