<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    // List all people
    public function list()
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        foreach ($users as $user) {
            // Check if image file exists, otherwise set to null for avatar fallback
            if ($user->img && file_exists(public_path('images/user/' . $user->img))) {
                $user->img = url('images/user/' . $user->img);
            } else {
                $user->img = 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=007bff&color=ffffff&size=40';
            }
        }
        return view('pages.people.view', ['users' => $users]);
    }

    // View Person Details
    public function viewEdit($id)
    {
        $user = User::find($id);
        if ($user->img && file_exists(public_path('images/user/' . $user->img))) {
            $user->img = url('images/user/' . $user->img);
        } else {
            $user->img = 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=007bff&color=ffffff&size=40';
        }
        return view('pages.people.edit', ['user' => $user]);
    }

    // Delete a person
    public function doDelete($id)
    {
        return redirect()->route('people');
    }
}
