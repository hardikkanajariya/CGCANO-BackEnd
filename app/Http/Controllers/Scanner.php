<?php

namespace App\Http\Controllers;

use App\Models\Barcodes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Scanner extends Controller
{
    // Function to view All Scanners' List
    public function list()
    {
        $scanners = \App\Models\Scanner::where('status', 1)->get();
        return view('pages.scanner.view')->with('scanners', $scanners);
    }

    // Function to view Add Scanner
    public function viewAdd()
    {
        return view('pages.scanner.add');
    }

    // Function to view Edit Scanner
    public function viewEdit($id)
    {
        $scanner = \App\Models\Scanner::find($id);
        if ($scanner) {
            return view('pages.scanner.edit')->with('scanner', $scanner);
        }else{
            return redirect()->route('scanner')->with('error', 'Scanner not found');
        }
    }

    // Function to view Does Add Scanner
    public function doAdd(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:scanners,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        try {
            $scanner = new \App\Models\Scanner();
            $scanner->name = $request->name;
            $scanner->fullname = $request->fullname;
            $scanner->email = $request->email;
            $scanner->password = Hash::make($request->password);
            $scanner->save();
            return redirect()->route('scanner')->with('success', 'Scanner added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again later');
        }
    }

    // Function to view Do Edit Scanner
    public function doEdit(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:scanners,email,'.$id,
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable|min:8'
        ]);
        try {
            $scanner = \App\Models\Scanner::find($id);
            if ($scanner) {
                $scanner->name = $request->name;
                $scanner->fullname = $request->fullname;
                $scanner->email = $request->email;
                if ($request->old_password != null) {
                    $request->validate([
                        'old_password' => 'required',
                    ]);
                    if (Hash::check($request->old_password, $scanner->password)) {
                        $request->validate([
                            'password' => 'required',
                            'confirm_password' => 'required|same:password',
                        ]);
                        $scanner->password = Hash::make($request->password);
                    }else{
                        return redirect()->back()->with('error', 'Old password is incorrect');
                    }
                }
                $scanner->save();
                return redirect()->route('scanner')->with('success', 'Scanner updated successfully');
            }
            return redirect()->back()->with('error', 'Scanner not found');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again later');
        }
    }

    // Function to view Delete Scanner
    public function doDelete($id)
    {
        try {
            $scanenr = \App\Models\Scanner::find($id);
            if ($scanenr) {
                $scanenr->status = 0;
                $scanenr->save();
                return redirect()->route('scanner')->with('success', 'Scanner deleted successfully');
            }
            return redirect()->back()->with('error', 'Scanner not found');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again later');
        }
    }

    // Function to view Login Scanner
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|exists:scanners,email',
            'password' => 'required',
        ]);

        $scanner = \App\Models\Scanner::where('email', $request->email)->first();

        if($scanner){
            if(Hash::check($request->password, $scanner->password)){
                $data = [
                    'id' => $scanner->id,
                    'name' => $scanner->name,
                    'fullname' => $scanner->fullname,
                    'email' => $scanner->email,
                ];
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'scanner' => $data,
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password is incorrect',
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Scanner not found',
            ]);
        }
    }

    // Function to Scan Ticket
    public function scanTicket(Request $request){
        $request->validate([
            'user_id' => 'required|exists:scanners,id',
            'barcode_id' => 'required|exists:barcodes,barcode_id',
        ]);

        $barcode = Barcodes::where('barcode_id', $request->barcode_id)->first();

        if($barcode){

            // Constraint: Barcode should not be used before and should not be expired yet
            if($barcode->is_used == 1){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ticket already scanned',
                ]);
            }else if($barcode->is_expired == 1){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ticket expired',
                ]);
            }else{
                // Constraint: Barcode should be used by the same scanner who scanned it first
                if($barcode->scanned_by != null){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Ticket already scanned by another scanner',
                    ]);
                }
            }

            $barcode->is_used = 1;
            $barcode->is_expired = 1;
            $barcode->scanned_by = $request->user_id;
            $barcode->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket scanned successfully',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found',
            ]);
        }
    }
}
