<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    // List all people
    public function list()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.people.view', ['users' => $users]);
    }

    // Delete a person
    public function doDelete($id)
    {
        return redirect()->route('people');
    }
}
