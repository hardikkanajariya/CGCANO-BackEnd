<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;

class TicketApiController extends Controller
{
    // get the ticket details by event slug
    public function getTicketDetails($slug)
    {
        $event = Events::where('slug', $slug)->first();

        // Get the ticket details
        if(!$event){
            return response()->json(['message' => 'Ticket is not available'], 404);
        }
        if(!$event->tickets){
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
}
