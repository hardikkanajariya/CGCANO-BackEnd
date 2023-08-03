<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    // Event Categories
    public function listCategories()
    {
        return view('pages.event.categories.view');
    }

    public function doAddCategory(Request $request)
    {
        return redirect()->route('event.categories');
    }
}
