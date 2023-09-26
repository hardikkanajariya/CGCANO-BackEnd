<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceComboMail;
use App\Mail\InvoiceTicketMail;
use App\Models\InvoiceCombo;
use App\Models\InvoiceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
            Mail::to($invoice->email)->cc($invoice->user->email)->send(new InvoiceTicketMail("invoices/{$invoice->pdf}", $invoice->full_name));
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
            Mail::to($invoice->email)->cc($invoice->user->email)->send(new InvoiceComboMail($invoice->id));
            return redirect()->back()->with('success', 'Invoice Email Sent Successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    // Function to Take Backup of the Database and send it to the user
    public function backup(Request $request)
    {

        // Get the email
        $email = auth()->user()->email;

//        Artisan::call('backup:run');
        $path = storage_path('app/CGCANO team/*');
        $latest_ctime = 0;
        $latest_filename = '';
        $files = glob($path);
        foreach($files as $file)
        {
            if (is_file($file) && filectime($file) > $latest_ctime)
            {
                $latest_ctime = filectime($file);
                $latest_filename = $file;
                // get the file name
                $latest_filename = basename($latest_filename);
            }
        }

//        return response()->download($latest_filename);

        // Send the email
        try{
            Mail::to($email)->send(new \App\Mail\BackupMail($latest_filename));
            return redirect()->back()->with('success', 'Backup Email Sent Successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
