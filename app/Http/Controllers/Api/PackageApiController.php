<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvoicePackage;
use App\Models\MemberShip;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

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

        foreach ($packages as $item) {
            $package = MemberShip::find($item->package_id);
            $downloadUrl = URL::to('/invoices/package/' . $item->pdf);
            $response[] = [
                'id' => $package->id,
                'name' => $package->name,
                'price' => $package->price,
                'is_paid' => $item->is_paid,
                'validity' => Carbon::parse($item->validity)->format('d M Y'),
                'download_url' => $downloadUrl,
            ];
        }

        return response()->json($response);
    }
}
