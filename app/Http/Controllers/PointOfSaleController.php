<?php

namespace App\Http\Controllers;

use App\Models\PontOfSale;
use App\Models\POSData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PointOfSaleController extends Controller
{
    // Function to view All Scanners List
    public function list()
    {
        $pos = PontOfSale::all();
        return view('pages.pos.view')->with('pos', $pos);
    }

    // Function to view Add Scanner
    public function viewAdd()
    {
        return view('pages.pos.add');
    }

    // Function to view Edit Scanner
    public function viewEdit($id)
    {
        $pos = PontOfSale::find($id);
        if ($pos == null) {
            return redirect()->back()->with('error', 'POS not found');
        }
        return view('pages.pos.edit')->with('pos', $pos);
    }

    // Function to view Do Add Scanner
    public function doAdd(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:point_of_sales',
            'email' => 'required|unique:point_of_sales|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        try{
            $pos = new PontOfSale();
            $pos->name = $request->name;
            $pos->username = $request->username;
            $pos->email = $request->email;
            $pos->password = Hash::make($request->password);
            $pos->save();
            return redirect()->route('pos')->with('success', 'POS has been added successfully');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to view Do Edit Scanner
    public function doEdit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:point_of_sales,username,'.$id,
            'email' => 'required|unique:point_of_sales,email,'.$id.'|email',
            'old_password' => 'nullable',
        ]);

        try{
            $pos = PontOfSale::find($id);
            if ($request->old_password) {
                if (Hash::check($request->old_password, $pos->password)) {
                    $request->validate([
                        'password' => 'required',
                        'confirm_password' => 'required|same:password',
                    ]);
                    $pos->password = Hash::make($request->password);
                }else{
                    return redirect()->back()->with('error', 'Old password is incorrect');
                }
            }
            $pos->name = $request->name;
            $pos->username = $request->username;
            $pos->email = $request->email;
            $pos->save();
            return redirect()->route('pos')->with('success', 'POS has been updated successfully');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to view Delete Scanner
    public function doDelete($id)
    {
        return view('pages.pos.delete');
    }

    // Function to view Scanner Details
    public function details($id)
    {
        return view('pages.pos.details');
    }
}
