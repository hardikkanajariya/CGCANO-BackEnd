<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserAuthentication extends Controller
{
    // Function to Log in User
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        // Get the user details
        $user = User::where('email', $request->email)->first();
        $user->image = url('images/user/' . $user->image);

        // Check if the password is correct
        if (Hash::check($request->password, $user->password)) {
            // Generate token
            $token = $user->createToken('auth_token')->accessToken;

            // get the user image url
            $user->image = url('images/user/' . $user->image);
            return response()->json([
                'message' => 'Logged in successfully',
                'token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid Password'
            ], 401);
        }
    }

    // Function to Register User
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create user
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password)
        ]);

        // Generate token
        $token = $user->createToken('auth_token')->accessToken;

        // get the user image url
        $user->image = url('images/user/' . $user->image);
        return response()->json([
            'message' => 'User Registered Successfully',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users',
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id . '|exists:users',
            'mobile' => 'required',
        ]);

        try {
            // Create user
            $user = User::find($request->id);
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->dob = $request->dob;
            $user->address = $request->mobile;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->postal_code = $request->postal_code;
            $user->save();

            return response()->json([
                'message' => 'User Updated Successfully',
                'user' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!, Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
