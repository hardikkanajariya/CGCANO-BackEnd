<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\POSData;
use Illuminate\Http\Request;

class PosController extends Controller
{
    // Function to Authentication Volunteer
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $pos = POSData::where('email', $request->email)->first();

        if (!$pos || !\Hash::check($request->password, $pos->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }else{
            $token = $pos->createToken('pos-token')->plainTextToken;

            $response = [
                'pos' => $pos,
                'token' => $token
            ];

            return response($response, 201);
        }
    }
}
