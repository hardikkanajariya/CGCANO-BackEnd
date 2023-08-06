<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function list()
    {
        $galleryItems = Gallery::all();
        return view('pages.gallery.view')->with('galleryItems', $galleryItems);
    }

    public function viewAdd()
    {
        return view('pages.gallery.add');
    }

    public function doAdd(Request $request)
    {
        $request->validate([
            'gallery' => 'required|array|min:1',
            'gallery.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try{
            $gallery = $request->file('gallery');
            $galleryItems = [];
            foreach ($gallery as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/gallery'), $name);
                $galleryItems[] = [
                    'path' => $name,
                ];
            }
            Gallery::insert($galleryItems);
            return redirect()->route('gallery')->with('success', 'Gallery uploaded successfully.');
        }catch (\Exception $e){
            return redirect()->route('gallery')->with('error', 'Gallery failed to upload.');
        }
    }

    public function doDelete($id)
    {
        try{
            $gallery = Gallery::find($id);
            // Delete image from folder
            $image_path = public_path('images/gallery/' . $gallery->path);
            if(file_exists($image_path)) {
                unlink($image_path);
            }
            $gallery->delete();
            return redirect()->route('gallery')->with('success', 'Gallery deleted successfully.');
        }catch (\Exception $e){
            return redirect()->route('gallery')->with('error', 'Gallery failed to delete.');
        }
    }
}
