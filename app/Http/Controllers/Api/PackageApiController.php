<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvoicePackage;
use App\Models\MemberShip;
use Carbon\Carbon;

class PackageApiController extends Controller
{
    // Function to get package Details By Id
    public function getPackageDetails($name)
    {
        $package = MemberShip::where('name', $name)->first();
        if ($package) {
            return response()->json([
                'id' => $package->id,
                'price' => $package->price,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Package Not Found',
            ]);
        }
    }

    // Function to get user packages
    public function getUserPackages($id)
    {
        $packages = InvoicePackage::where('user_id', $id)->where('is_paid', 1)->get();
        $response = [];
        if (!$packages) {
            return response()->json([
                'status' => false,
                'message' => 'No Packages Found',
            ]);
        }

        foreach ($packages as $package) {
            $package = MemberShip::find($package->id);
            $response[] = [
                'id' => $package->id,
                'name' => $package->package->name,
                'price' => $package->package->price,
                'is_paid' => $package->is_paid,
                'validity' => Carbon::parse($package->validity)->format('d M Y'),
            ];
        }

        return response()->json($response);
    }
}
