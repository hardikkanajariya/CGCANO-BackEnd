<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // Function to handle Email Template Flyer
    public function handle(Request $request)
    {
        return view('pages.settings.handle');
    }

    // Function to handle Email Template Flyer update
    public function handleUpdate(Request $request){
        $request->validate([
            'event_id' => 'required|exists:events,id|unique:settings,event_id,'.$request->id,
            'flyer' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
}
