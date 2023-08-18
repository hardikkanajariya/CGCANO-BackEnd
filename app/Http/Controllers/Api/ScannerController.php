<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scanner;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice;

class ScannerController extends Controller
{
    // Handling Authentication for Scanner Application
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if Scanner Exists
        $scanner = Scanner::where('email', $request->email)->first();

        if(!$scanner){
            return response()->json([
                'status' => 'error',
                'message' => 'Scanner not found'
            ], 404);
        }

        // Check if Password is Correct
        if(!Hash::check($request->password, $scanner->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Password'
            ], 401);
        }

        // Send Scanner Details
        return response()->json([
            'status' => 'success',
            'data' => $scanner
        ]);
    }

    // Function to Scan Ticket
    public function scanTicket(Request $request){
        $request->validate([
            'invoice_id' => 'required'
        ]);

        // Check if Invoice Exists
        $invoice = Invoice::where('id', $request->invoice_id)->first();

        if(!$invoice){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Ticket'
            ], 404);
        }
    }
}
