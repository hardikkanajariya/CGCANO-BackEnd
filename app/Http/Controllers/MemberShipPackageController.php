<?php

namespace App\Http\Controllers;

use App\Models\MemberShip;
use Illuminate\Http\Request;

class MemberShipPackageController extends Controller
{
    // Function to View All Packages
    public function listPackage(){
        $packages = MemberShip::all();
        return view('pages.package.view', compact('packages'));
    }

    // Function to view Add Package
    public function viewAddPackage(){
        return view('pages.package.add');
    }

    // Function to Add Package
    public function doAddPackage(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'validity' => 'required|numeric'
        ]);
        $package = new MemberShip();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->discount = $request->discount ?? 0;
        $package->percentage = $request->percentage;
        $package->validity = '+'.$request->validity.' days';
        $package->status = 1;
        $package->save();
        return redirect()->route('membership')->with('success', 'Package Added Successfully');
    }

    // Function to view Edit Package
    public function viewEditPackage($id){
        $package = MemberShip::find($id);
        return view('pages.package.edit', compact('package'));
    }

    // Function to Edit Package
    public function doEditPackage(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'validity' => 'required|numeric'
        ]);
        $package = MemberShip::find($id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->discount = $request->discount ?? 0;
        $package->percentage = $request->percentage;
        $package->validity = '+'.$request->validity.' days';
        $package->save();
        return redirect()->route('membership')->with('success', 'Package Updated Successfully');
    }

    // Function to Delete Package
    public function doDeletePackage($id){
        $package = MemberShip::find($id);
        $package->delete();
        return redirect()->route('membership')->with('success', 'Package Deleted Successfully');
    }
}
