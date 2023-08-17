<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Function to show the ticket form
    public function viewAdd($event)
    {
        $event = Events::where('slug', $event)->firstOrFail();
        return view('pages.ticket.add', compact('event'));
    }

    // Function to add a ticket
    public function doAdd(Request $request, $event)
    {
        // Validate the form
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        // Get the event
        $event = Events::where('slug', $event)->firstOrFail();

        // Event can only have 1 ticket
        if ($event->tickets()->count() > 0) {
            return redirect()->back()->with('error', 'Event already has a ticket');
        }

        // Create the ticket
        $ticket = $event->tickets()->create([
            'price' => $request->price,
            'quantity' => $request->quantity,
            'tickets_left' => $request->quantity,
        ]);

        // Redirect to the event page
        return redirect()->route('event')->with('success', 'Ticket added successfully');
    }
    // Function to view the edit ticket form
    public function viewEdit($id)
    {
        // Get the ticket
        $ticket = Tickets::where('id', $id)->firstOrFail();

        // get the event
        $event = $ticket->event()->firstOrFail();
        // Return the view
        return view('pages.ticket.edit', compact( 'ticket', 'event'));
    }

    // Function to update a ticket
    public function doEdit(Request $request, $id)
    {
        // Validate the form
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        // Get the ticket
        $ticket = Tickets::where('id', $id)->firstOrFail();

        // Update the ticket
        $ticket->update([
            'price' => $request->price,
            'quantity' => $request->quantity,
            'tickets_left' => $request->quantity,
            'is_sold_out' => $request->quantity == 0,
        ]);

        // Redirect to the event page
        return redirect()->route('event')->with('success', 'Ticket updated successfully');
    }

    // Function to delete a ticket
    public function doDelete($id)
    {
        // Get the ticket
        $ticket = Tickets::where('id', $id)->firstOrFail();
        // Delete the ticket
        $ticket->delete();
        // Redirect to the event page
        return redirect()->route('event')->with('success', 'Ticket deleted successfully');
    }

    // Function to mark a ticket as sold out
    public function doSoldOut($id)
    {
        // Get the ticket
        $ticket = Tickets::where('id', $id)->firstOrFail();
        // Update the ticket
        $ticket->update([
            'is_sold_out' => true,
        ]);

        // Redirect to the event page
        return redirect()->route('event')->with('success', 'Ticket marked as sold out successfully');
    }
}
