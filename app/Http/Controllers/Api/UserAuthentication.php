<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthentication extends Controller
{
    // Function to Log in User
    public function login(Request $request){
        $request->validate([
           'email' => 'required|email|exists:users',
           'password' => 'required'
        ]);

        // Get the user details
        $user = User::where('email', $request->email)->first();

        // Check if the password is correct
        if(Hash::check($request->password, $user->password)){
            // Generate token
            $token = $user->createToken('auth_token')->accessToken;
            return response()->json([
                'message' => 'Logged in successfully',
                'token' => $token,
                'user' => $user
            ]);
        }else{
            return response()->json([
                'message' => 'Invalid Password'
            ], 401);
        }
    }

    // Function to Register User
    public function register(Request $request){
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
        return response()->json([
            'message' => 'User Registered Successfully',
            'token' => $token,
            'user' => $user
        ]);
    }
}
