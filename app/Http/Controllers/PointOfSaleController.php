<?php

namespace App\Http\Controllers;

use App\Models\Volunteers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class PointOfSaleController extends Controller
{
    // Function to view All volunteers List
    public function list()
    {
        $pos = Volunteers::all();
        return view('pages.pos.view')->with('pos', $pos);
    }

    // Function to view Add volunteers
    public function viewAdd()
    {
        return view('pages.pos.add');
    }

    // Function to view Edit volunteers
    public function viewEdit($id)
    {
        $pos = Volunteers::find($id);
        if ($pos == null) {
            return redirect()->back()->with('error', 'Volunteer not found');
        }
        return view('pages.pos.edit')->with('pos', $pos);
    }

    // Function to view Does Add volunteers
    public function doAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:volunteers',
            'phone' => 'required|unique:volunteers',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            $pos = new Volunteers();
            $pos->name = $request->name;
            $pos->email = $request->email;
            $pos->phone = $request->phone;
            $pos->password = Hash::make($request->password);
            $pos->status = $request->status ? 1 : 0;
            $pos->save();
            return redirect()->route('pos')->with('success', 'Volunteer has been added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to view Do Edit volunteers
    public function doEdit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:volunteers,email,' . $id,
            'phone' => 'required|unique:volunteers,phone,' . $id,
            'password' => 'nullable',
            'confirm_password' => 'nullable|same:password',
            'old_password' => 'nullable',
        ]);

        try {
            $pos = Volunteers::find($id);
            $pos->name = $request->name;
            $pos->email = $request->email;
            $pos->phone = $request->phone;
            $pos->status = $request->status ? 1 : 0;
            if ($request->password != null) {
                // Confirm Old Password
                if (!\Hash::check($request->old_password, $pos->password)) {
                    return redirect()->back()->with('error', 'Old Password is not correct');
                }

                $pos->password = Hash::make($request->password);
            }
            $pos->save();
            return redirect()->route('pos')->with('success', 'Volunteer has been updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to view Delete volunteers
    public function doDelete($id)
    {
        try {
            $pos = Volunteers::find($id);
            $pos->delete();
            return redirect()->route('pos')->with('success', 'Volunteer has been deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
