<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barcodes;
use App\Models\Events;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class TicketApiController extends Controller
{
    // get the ticket details by event slug
    public function getTicketDetails($slug)
    {
        $event = Events::where('slug', $slug)->first();

        // Get the ticket details
        if (!$event) {
            return response()->json(['message' => 'Ticket is not available'], 404);
        }
        if (!$event->tickets) {
            return response()->json(['message' => 'Ticket is not available'], 404);
        }
        $ticket = $event->tickets;
        // check if the ticket is not sold out and is active
        if ($ticket->is_sold_out == 1 || $ticket->is_active == 0) {
            return response()->json(['message' => 'Ticket is not available'], 404);
        }
        $response = [
            'id' => $ticket->id,
            'price' => $ticket->price,
            'quantity' => $ticket->quantity,
            'is_sold_out' => $ticket->is_sold_out,
            'tickets_left' => $ticket->tickets_left,
        ];
        return response()->json($response);
    }

    // Function to get the user tickets
    public function getUserTickets($id)
    {
        $user_invoice = Invoice::where('user_id', $id)->get();

        if (!$user_invoice) {
            return response()->json(['message' => 'No tickets found'], 404);
        }

        $response = [];
        foreach ($user_invoice as $invoice) {
            // Get the Ticket Details
            $ticket = $invoice->ticket;
            $event = $ticket->event;
            $barcode = Barcodes::where('invoice_id', $invoice->id)->first();
            $hash = md5($barcode->barcode_id); // Using md5 for URL-safe hash
            $downloadUrl = URL::to('/invoices/' . $hash . '.pdf');
            $response[] = [
                'id' => $invoice->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'date' => Carbon::parse($invoice->created_at)->format('M d Y h:i A'),
                'price' => $ticket->price,
                'tickets' => $invoice->quantity,
                'total_amount' => $invoice->total_amount,
                'is_paid' => $invoice->is_paid,
                'purchased_at' => $invoice->created_at,
                'download_url' => $downloadUrl,
            ];
        }
        return response()->json($response);
    }
}
