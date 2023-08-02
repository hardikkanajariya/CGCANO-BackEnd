<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Scanner extends Controller
{
    // Function to view All Scanners List
    public function list()
    {
        $scanners = \App\Models\Scanner::all();
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

    // Function to view Do Add Scanner
    public function doAdd(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:scanners,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);
        try {
            $scanner = new \App\Models\Scanner();
            $scanner->name = $request->name;
            $scanner->username = $request->username;
            $scanner->email = $request->email;
            $scanner->password = Hash::make($request->password);
            $scanner->save();
            return redirect()->route('scanner')->with('success', 'Scanner added successfully');
        } catch (Exception $e) {
            return redirect()->route('scanner')->with('error', 'Something went wrong, please try again later');
        }
    }

    // Function to view Do Edit Scanner
    public function doEdit(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:scanners,email,'.$id,
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable|min:8'
        ]);
        try {
            $scanner = \App\Models\Scanner::find($id);
            if ($scanner) {
                $scanner->name = $request->name;
                $scanner->username = $request->username;
                $scanner->email = $request->email;
                if ($request->password) {
                    $scanner->password = Hash::make($request->password);
                }
                $scanner->save();
                return redirect()->route('scanner')->with('success', 'Scanner updated successfully');
            }
            return redirect()->route('scanner')->with('error', 'Scanner not found');
        } catch (Exception $e) {
            return redirect()->route('scanner')->with('error', 'Something went wrong, please try again later');
        }
    }

    // Function to view Delete Scanner
    public function doDelete($id)
    {
        try {
            $scanenr = \App\Models\Scanner::find($id);
            if ($scanenr) {
                $scanenr->delete();
                return redirect()->route('scanner')->with('success', 'Scanner deleted successfully');
            }
            return redirect()->route('scanner')->with('error', 'Scanner not found');
        } catch (Exception $e) {
            return redirect()->route('scanner')->with('error', 'Something went wrong, please try again later');
        }
    }
}
