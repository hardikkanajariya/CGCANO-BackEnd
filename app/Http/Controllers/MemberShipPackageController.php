<?php

namespace App\Http\Controllers;

use App\Models\MemberShipPackage;
use Illuminate\Http\Request;

class MemberShipPackageController extends Controller
{
    // Function to View All Packages
    public function listPackage(){
        $packages = MemberShipPackage::all();
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
            'description' => 'required'
        ]);
        $package = new MemberShipPackage();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->discount = $request->discount ?? 0;
        $package->percentage = $request->percentage ?? 0;
        $package->status = 1;
        $package->save();
        return redirect()->route('membership')->with('success', 'Package Added Successfully');
    }

    // Function to view Edit Package
    public function viewEditPackage($id){
        $package = MemberShipPackage::find($id);
        return view('pages.package.edit', compact('package'));
    }

    // Function to Edit Package
    public function doEditPackage(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);
        $package = MemberShipPackage::find($id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->discount = $request->discount ?? 0;
        $package->percentage = $request->percentage ?? 0;
        $package->save();
        return redirect()->route('membership')->with('success', 'Package Updated Successfully');
    }

    // Function to Delete Package
    public function doDeletePackage($id){
        $package = MemberShipPackage::find($id);
        $package->delete();
        return redirect()->route('membership')->with('success', 'Package Deleted Successfully');
    }
}
