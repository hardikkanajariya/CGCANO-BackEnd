<?php

namespace App\Http\Controllers;

use App\Models\Speakers;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    // Function to view All speakers list
    public function list()
    {
        $speakers = Speakers::where('status', 1)->get();
        return view('pages.speaker.view')->with('speakers', $speakers);
    }

    // Function to view Add Speaker
    public function viewAdd()
    {
        return view('pages.speaker.add');
    }

    // Function to Add Speaker
    public function doAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'website' => 'nullable|url'
        ]);

        try{
            $speaker = new Speakers();
            $speaker->name = $request->name;
            $speaker->title = $request->title;
            $speaker->description = $request->description;
            $speaker->website = $request->website;
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/speaker'), $imageName);
            $speaker->image = $imageName;
            $speaker->save();
            return redirect()->route('speaker')->with('success', 'Speaker Added Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to view Edit Speaker
    public function viewEdit($id)
    {
        $speaker = Speakers::find($id);
        return view('pages.speaker.edit')->with('speaker', $speaker);
    }

    // Function to Edit Speaker
    public function doEdit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'website' => 'required|url'
        ]);

        try{
            $speaker = Speakers::find($id);
            $speaker->name = $request->name;
            $speaker->title = $request->title;
            $speaker->description = $request->description;
            $speaker->website = $request->website;
            if($request->image){
                // Delete Old Image
                $image_path = public_path('images/speaker/'.$speaker->image);
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
                // Upload New Image
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images/speaker'), $imageName);
                $speaker->image = $imageName;
            }
            $speaker->save();
            return redirect()->route('speaker')->with('success', 'Speaker Updated Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Function to Delete Speaker
    public function doDelete($id)
    {
        try{
            $speaker = Speakers::find($id);
            // Delete Old Image
//            $image_path = public_path('images/speaker/'.$speaker->image);
//            if(file_exists($image_path)) {
//                unlink($image_path);
//            }
            $speaker->status = 0;
            $speaker->save();
            return redirect()->route('speaker')->with('success', 'Speaker Deleted Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
