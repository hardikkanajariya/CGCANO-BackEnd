<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuestAccountController extends Controller
{
    public function index()
    {
        $guestAccounts = User::where('is_guest_account', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.guest-accounts.index', compact('guestAccounts'));
    }

    public function convertToRegular($id)
    {
        $user = User::findOrFail($id);

        if (!$user->is_guest_account) {
            return redirect()->back()->with('error', 'This is not a guest account');
        }

        $user->update([
            'is_guest_account' => false,
            'created_by' => 'converted_from_guest'
        ]);

        return redirect()->back()->with('success', 'Guest account converted to regular account successfully');
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:6'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->new_password),
            'temp_password_sent_at' => now()
        ]);

        return redirect()->back()->with('success', 'Password reset successfully');
    }
}
