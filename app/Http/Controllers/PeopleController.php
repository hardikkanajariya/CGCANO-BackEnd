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
        foreach ($users as $user) {
            $user->img = url('images/user/' . $user->img);
        }
        return view('pages.people.view', ['users' => $users]);
    }

    // View Person Details
    public function viewEdit($id)
    {
        $user = User::find($id);
        $user->img = url('images/user/' . $user->img);
        return view('pages.people.edit', ['user' => $user]);
    }

    // Delete a person
    public function doDelete($id)
    {
        return redirect()->route('people');
    }
}
