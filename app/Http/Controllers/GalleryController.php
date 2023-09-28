<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function list()
    {
        // List all gallery items with category
        $galleryItems = Gallery::with('category')->get();
        // Get Collection of Categories from Gallery Items
        $cates = $galleryItems->pluck('category')->unique();
        $categories = [];
        foreach ($cates as $category) {
            $categories[] = [
                'id' => $category->id,
                'name' => $category->name
            ];
        }
        $data = [
            'galleryItems' => $galleryItems,
            'categories' => $categories,
        ];
        return view('pages.gallery.view')->with($data);
    }

    public function viewAdd()
    {
        $categoryItems = EventCategory::where('status', 1)->get();
        return view('pages.gallery.add')->with('categoryItems', $categoryItems);
    }

    public function doAdd(Request $request)
    {
        $request->validate([
            'gallery' => 'required|array|min:1',
            'gallery.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:event_categories,id',
        ]);

        try{
            $gallery = $request->file('gallery');
            $galleryItems = [];
            foreach ($gallery as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/gallery'), $name);
                $galleryItems[] = [
                    'path' => $name,
                    'category_id' => $request->category_id,
                ];
            }
            Gallery::insert($galleryItems);
            return redirect()->route('gallery')->with('success', 'Gallery uploaded successfully.');
        }catch (\Exception $e){
            // return redirect()->route('gallery')->with('error', 'Gallery failed to upload.');
            return redirect()->route('gallery')->with('error', $e->getMessage());
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
            return redirect()->route('gallery')->with('success', 'Image deleted successfully.');
        }catch (\Exception $e){
            return redirect()->route('gallery')->with('error', 'Image failed to delete.');
        }
    }
}
