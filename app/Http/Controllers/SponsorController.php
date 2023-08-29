<?php

namespace App\Http\Controllers;

use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    // List all sponsor
    public function list()
    {
        $sponsors = Sponsors::where('status', 1)->get();
        return view('pages.sponsor.view', ['sponsors' => $sponsors]);
    }

    // Add sponsor
    public function viewAdd()
    {
        return view('pages.sponsor.add');
    }

    // Add sponsor
    public function doAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'description' => 'required|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'website' => 'required|url'
        ]);

        try{
            $sponsor = new Sponsors();
            $sponsor->name = $request->name;
            $sponsor->description = $request->description;
            $sponsor->website = $request->website;
            $sponsor->event_id = null;
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/sponsor'), $imageName);
            $sponsor->logo = $imageName;
            $sponsor->save();
            return redirect()->route('sponsor')->with('success', 'Sponsor Added Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Edit sponsor
    public function viewEdit($id)
    {
        $sponsor = Sponsors::find($id);
        if (!$sponsor) {
            return redirect()->route('sponsor')->with(['error' => 'Cannot find sponsor!']);
        }
        return view('pages.sponsor.edit', ['sponsor' => $sponsor]);
    }

    // Edit sponsor
    public function doEdit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'description' => 'required|min:10',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'website' => 'required|url'
        ]);

        try{
            $sponsor = Sponsors::find($id);
            $sponsor->name = $request->name;
            $sponsor->description = $request->description;
            $sponsor->website = $request->website;
            if($request->image){
                // Delete Old Image
                $image_path = public_path('images/sponsor/'.$sponsor->logo);
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
                // Upload New Image
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images/sponsor'), $imageName);
                $sponsor->logo = $imageName;
            }
            $sponsor->save();
            return redirect()->route('sponsor')->with('success', 'Sponsor Updated Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Delete sponsor
    public function doDelete($id)
    {
        try{
            $sponsor = Sponsors::find($id);
            // Delete Old Image
//            $image_path = public_path('images/sponsor/'.$sponsor->logo);
//            if(file_exists($image_path)) {
//                unlink($image_path);
//            }
            $sponsor->status = 0;
            $sponsor->save();
            return redirect()->route('sponsor')->with('success', 'Sponsor Deleted Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
