<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplates;
use App\Models\EventList;
use App\Models\Events;
use App\Models\TicketCombo;
use App\Models\TicketEvent;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    // Function to list all Email Templates
    public function list()
    {
        $templates = EmailTemplates::where('status', 1)->get();
        return view('pages.templates.view', compact('templates'));
    }

    // Function to create Email Template
    public function viewAdd()
    {
        // Get All Active Events
        $events = EventList::where('status', 1)->get();
        return view('pages.templates.add')->with('events', $events);
    }

    // Function to store Email Template
    public function viewEdit(Request $request, $id)
    {
        $template = EmailTemplates::find($id);
        return view('pages.templates.edit')->with($template);
    }

    // Function to Do Add Email Template
    public function doAdd(Request $request)
    {
        // Validate the form
        $request->validate([
            'event_id' => 'required|exists:event_list,id',
            'subject' => 'required',
            'body' => 'required',
            'image' => 'required|image'
        ]);

        // Get the Event Details
        $event = EventList::find($request->event_id);

        // Upload the image
        $image = time() . '.' . $request->image->extension();
        $request->image->move(public_path('flyer'), $image);

        // Create the combo ticket
        $ticket = EmailTemplates::create([
            'subject' => $request->name ?? $event->title, // Default subject is Event Title
            'body' => $request->description ?? '', // Default body is BLANK
            'flyer' => $image,
            'event_id' => $request->event_id,
        ]);

        // Redirect to the Email Template List
        return redirect()->route('settings.email')->with('success', 'Email Template added successfully');
    }

}
