<?php

namespace App\Http\Controllers;

use App\Models\SubscribedList;
use Illuminate\Http\Request;

class SubScribedController extends Controller
{
    // Function to add Subscribed Email
    public function addSubscribed(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $subscribed = new SubscribedList();
        $subscribed->email = $request->email;
        $subscribed->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscribed successfully'
        ]);
    }

    // Function to get All Subscribed Email List
    public function list()
    {
        $subscribed = SubscribedList::all();
        $data = compact('subscribed');
        return view('pages.subscribed.view')->with($data);
    }

    // Function to delete Subscribed Email
    public function delete($id)
    {
        $subscribed = SubscribedList::find($id);
        $subscribed->delete();
        return redirect()->back()->with('success', 'Subscribed Email deleted successfully');
    }

    // Function to subscribe Email
    public function subscribe($id)
    {
        $subscribed = SubscribedList::find($id);
        $subscribed->status = 1;
        $subscribed->save();
        return redirect()->back()->with('success', 'Subscribed successfully');
    }

    // Function to unsubscribe Email
    public function unsubscribe($id)
    {
        $subscribed = SubscribedList::find($id);
        $subscribed->status = 0;
        $subscribed->save();
        return redirect()->back()->with('success', 'Unsubscribed successfully');
    }
}
