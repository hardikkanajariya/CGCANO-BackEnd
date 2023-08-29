<?php

namespace App\Http\Controllers;

use App\Models\TicketCombo;
use App\Models\EventList;
use App\Models\TicketEvent;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Function to view All TicketEvent
    public function list()
    {
        // Get all the tickets
        $tickets = TicketEvent::all();

        // Return the view
        return view('pages.ticket.view', compact('tickets'));
    }

    // Function to show the ticket form
    public function viewAdd($event)
    {
        $event = EventList::where('slug', $event)->firstOrFail();
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
        $event = EventList::where('slug', $event)->firstOrFail();

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
        $ticket = TicketEvent::where('id', $id)->firstOrFail();

        // get the event
        $event = $ticket->event()->firstOrFail();
        // Return the view
        return view('pages.ticket.edit', compact('ticket', 'event'));
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
        $ticket = TicketEvent::where('id', $id)->firstOrFail();

        // Update the ticket
        $ticket->update([
            'price' => $request->price,
            'quantity' => $request->quantity,
            'tickets_left' => $request->quantity,
            'is_sold_out' => $request->quantity == 0,
        ]);

        // Redirect to the event page
        return redirect()->route('ticket')->with('success', 'Ticket updated successfully');
    }

    // Function to delete a ticket
    public function doDelete($id)
    {
        // Get the ticket
        $ticket = TicketEvent::where('id', $id)->firstOrFail();
        // Delete the ticket
        $ticket->status = 0;
        $ticket->save();
        // Redirect to the event page
        return redirect()->route('event')->with('success', 'Ticket deleted successfully');
    }

    // Function to mark a ticket as sold out
    public function doSoldOut($id)
    {
        // Get the ticket
        $ticket = TicketEvent::where('id', $id)->firstOrFail();
        // Update the ticket
        $ticket->update([
            'is_sold_out' => true,
        ]);

        // Redirect to the event page
        return redirect()->route('event')->with('success', 'Ticket marked as sold out successfully');
    }

    /* Handle Combo TicketEvent */
    // Function to view All Combo TicketEvent
    public function listCombo()
    {
        // Get all the combo tickets
        $tickets = TicketCombo::where('status', 1)->get();

        // Return the view
        return view('pages.ticket.combo.view', compact('tickets'));
    }

    // Function to show the combo ticket form
    public function viewAddCombo()
    {
        $allEvents = EventList::where('status', '1')->get();
        $events= [];
        foreach ($allEvents as $event) {
            $ticket = TicketEvent::where('event_id', $event->id)->first();
            if ($ticket) {
                if ($ticket->is_sold_out) {
                    continue;
                }
                if ($ticket->is_active == false) {
                    continue;
                }
                $events[] = $event;
            }
        }
        return view('pages.ticket.combo.add', compact('events'));
    }

    // Function to add a combo ticket
    public function doAddCombo(Request $request)
    {
        // Validate the form
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'quantity' => 'required|numeric',
            'events' => 'required|array',
        ]);

        // Get The Ticket Details From Event id
        foreach ($request->events as $event) {
            $ticket = TicketEvent::where('event_id', $event)->first();
            if (!$ticket) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'No Ticket Found For This Event ' . $event->title . ' Please Add Ticket First');
            }

            if ($ticket->is_sold_out) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'Ticket For This Event ' . $event->title . ' Is Sold Out');
            }

            if ($ticket->tickets_left < $request->quantity) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'Not Enough TicketEvent Left For This Event ' . $event->title . ' Please Reduce The Quantity or Add More Tickets For This Event');
            }

            if ($ticket->is_active == false) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'Ticket For This Event ' . $event->title . ' Is Not Active');
            }
        }



        // Upload the image
        $image = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/combos'), $image);

        // Create the combo ticket
        $ticket = TicketCombo::create([
            'name' => $request->name ?? 'Combo Ticket', // Default name is 'Combo Ticket
            'description' => $request->description ?? 'Combo Ticket', // Default description is 'Combo Ticket
            'price' => $request->price,
            'image' => $image,
            'quantity' => $request->quantity,
            'event_id' => json_encode($request->events),
            'status' => 1, // Default status is 1
        ]);

        // Redirect to the event page
        return redirect()->route('ticket.combo')->with('success', 'Combo Ticket added successfully');
    }


    // Function to view the edit combo ticket form
    public function viewEditCombo($id)
    {

        $allEvents = EventList::where('status', '1')->get();
        $events= [];
        foreach ($allEvents as $event) {
            $ticket = TicketEvent::where('event_id', $event->id)->first();
            if ($ticket) {
                if ($ticket->is_sold_out) {
                    continue;
                }
                if ($ticket->is_active == false) {
                    continue;
                }
                $events[] = $event;
            }
        }
        // Get the combo ticket
        $ticket = TicketCombo::where('id', $id)->firstOrFail();

        // Return the view
        return view('pages.ticket.combo.edit', compact('ticket', 'events'));
    }

    // Function to update a combo ticket
    public function doEditCombo(Request $request, $id)
    {
        // Validate the form
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'image',
            'quantity' => 'required|numeric',
            'events' => 'required|array',
        ]);

        // Get The Ticket Details From Event id
        foreach ($request->events as $event) {
            $ticket = TicketEvent::where('event_id', $event)->first();
            if (!$ticket) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'No Ticket Found For This Event ' . $event->title . ' Please Add Ticket First');
            }

            if ($ticket->is_sold_out) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'Ticket For This Event ' . $event->title . ' Is Sold Out');
            }

            if ($ticket->tickets_left < $request->quantity) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'Not Enough TicketEvent Left For This Event ' . $event->title . ' Please Reduce The Quantity or Add More Tickets For This Event');
            }

            if ($ticket->is_active == false) {
                $event = EventList::where('id', $event)->first();
                return redirect()->back()->with('error', 'Ticket For This Event ' . $event->title . ' Is Not Active');
            }
        }

        // Get the combo ticket
        $ticket = TicketCombo::where('id', $id)->firstOrFail();

        // Upload the image
        if ($request->hasFile('image')) {
            // $image = $request->file('image')->store('public/images/combos');
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/combos'), $image);
        } else {
            $image = $ticket->image;
        }

        // Update the combo ticket
        $ticket->update([
            'name' => $request->name ?? 'Combo Ticket', // Default name is 'Combo Ticket
            'description' => $request->description ?? 'Combo Ticket', // Default description is 'Combo Ticket
            'price' => $request->price,
            'image' => $image,
            'quantity' => $request->quantity,
            'event_id' => json_encode($request->events),
            'status' => 1, // Default status is 1
        ]);

        // Redirect to the event page
        return redirect()->route('ticket.combo')->with('success', 'Combo Ticket updated successfully');
    }

    // Function to delete a combo ticket
    public function doDeleteCombo($id)
    {
        // Get the combo ticket
        $ticket = TicketCombo::where('id', $id)->firstOrFail();
        // Delete the combo ticket
        $ticket->status = 0;
        $ticket->save();
        // Redirect to the event page
        return redirect()->back()->with('success', 'Combo Ticket deleted successfully');
    }

    // Function to mark a combo ticket as sold out
    public function doSoldOutCombo($id)
    {
        // Get the combo ticket
        $ticket = TicketCombo::where('id', $id)->firstOrFail();
        // Update the combo ticket
        $ticket->update([
            'status' => false,
        ]);

        // Redirect to the event page
        return redirect()->back()->with('success', 'Combo Ticket marked as sold out successfully');
    }
}
