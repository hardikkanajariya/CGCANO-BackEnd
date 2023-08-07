<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    // Function to get All Contact Request List
    public function list()
    {
        $contacts = ContactRequest::all();
        $data = compact('contacts');
        return view('pages.contacts.view')->with($data);
    }

    // Function to create Contact Request
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
            'phone' => 'required',
            'subject' => 'required',
        ]);

        $contact = new ContactRequest();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->subject = $request->subject;
        $contact->is_read = 0;
        $contact->phone = $request->phone;
        $contact->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact Request sent successfully'
        ]);
    }

    // Function to mark Contact Request as Read
    public function markAsRead($id)
    {
        $contact = ContactRequest::find($id);
        $contact->is_read = 1;
        $contact->save();
        return redirect()->back()->with('success', 'Contact Request marked as read successfully');
    }

    // Function to mark contact as Unread
    public function markAsUnread($id)
    {
        $contact = ContactRequest::find($id);
        $contact->is_read = 0;
        $contact->save();
        return redirect()->back()->with('success', 'Contact Request marked as unread successfully');
    }

    // Function to delete Contact Request
    public function doDelete($id)
    {
        $contact = ContactRequest::find($id);
        $contact->delete();
        return redirect()->back()->with('success', 'Contact Request deleted successfully');
    }
}
