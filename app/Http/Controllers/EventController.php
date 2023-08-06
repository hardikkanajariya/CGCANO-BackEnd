<?php

namespace App\Http\Controllers;

use App\Models\EventAmenities;
use App\Models\EventCategory;
use App\Models\Venues;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Event Venue Amenities Handler (CRUD)
    public function listAmenities()
    {
        $amenities = EventAmenities::all();
        return view('pages.event.venues.amenities.view', ['amenities' => $amenities]);
    }
    public function viewAddAmenities()
    {
        return view('pages.event.venues.amenities.add');
    }
    public function doAddAmenities(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $amenities = new EventAmenities();
            $amenities->name = $request->name;
            $amenities->description = $request->description;
            $imageName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('images/event/venue/amenities'), $imageName);
            $amenities->image = $imageName;
            $amenities->save();
            return redirect()->back()->with('success', 'Amenities added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('event.venue.add')->with('error', 'Failed to add amenities.');
        }
    }
    public function viewEditAmenities($id)
    {
        $amenities = EventAmenities::find($id);
        return view('pages.event.venues.amenities.edit', ['amenities' => $amenities]);
    }
    public function doEditAmenities(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        try {
            $amenities = EventAmenities::find($id);
            $amenities->name = $request->name;
            $amenities->description = $request->description;
            if ($request->hasFile('file')) {
                $request->validate([
                    'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $imageName = time() . '.' . $request->file->extension();
                $request->file->move(public_path('images/event/venue/amenities'), $imageName);
                $amenities->image = $imageName;
            }
            $amenities->save();
            return redirect()->route('event.venue.amenities')->with('success', 'Amenities edited successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('event.venue.amenities.edit', ['id' => $id])->with('error', 'Failed to edit amenities.');
        }
    }
    public function doDeleteAmenities($id)
    {
        try {
            $amenities = EventAmenities::find($id);
            // delete image
            $image_path = public_path('images') . '/event/venue/amenities' . $amenities->image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $amenities->delete();
            return redirect()->route('event.venue.amenities')->with('success', 'Amenities deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('event.venue.amenities')->with('error', 'Failed to delete amenities.');
        }
    }
    // Event Venue Handler (CRUD)
    public function listVenues()
    {
        $venues = Venues::all();
        return view('pages.event.venues.view', ['venues' => $venues]);
    }
    public function viewAddVenue()
    {
        $amenities = EventAmenities::all();
        return view('pages.event.venues.add', ['amenities' => $amenities]);
    }
    public function doAddVenue(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'city' => 'required|alpha',
            'state' => 'required|alpha',
            'country' => 'required|alpha',
            'postal_code' => 'required|numeric',
            'amenities' => 'required|array',
        ]);
        try {
            $venue = new Venues();
            $venue->name = $request->name;
            $venue->description = $request->description;
            $venue->address = $request->address;
            $venue->city = $request->city;
            $venue->state = $request->state;
            $venue->country = $request->country;
            $venue->postal_code = $request->postal_code;
            $venue->amenities = json_encode($request->amenities);
            $venue->save();
            return redirect()->route('event.venues')->with('success', 'Venue added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('event.venue.add')->with('error', 'Failed to add venue.');
        }
    }
    public function viewEditVenue($id)
    {
        $venue = Venues::find($id);
        $amenities = json_decode($venue->amenities);
        return view('pages.event.venues.edit', ['venue' => $venue, 'amenities' => $amenities]);
    }
    public function doEditVenue(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'city' => 'required|alpha',
            'state' => 'required|alpha',
            'country' => 'required|alpha',
            'postal_code' => 'required|numeric',
            'amenities' => 'required|array',
        ]);
        try {
            $venue = Venues::find($id);
            $venue->name = $request->name;
            $venue->description = $request->description;
            $venue->address = $request->address;
            $venue->city = $request->city;
            $venue->state = $request->state;
            $venue->country = $request->country;
            $venue->postal_code = $request->postal_code;
            $venue->amenities = json_encode($request->amenities);
            $venue->save();
            return redirect()->route('event.venues')->with('success', 'Venue edited successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('event.venue.edit', ['id' => $id])->with('error', 'Failed to edit venue.');
        }
    }
    public function doDeleteVenue($id)
    {
        try {
            $venue = Venues::find($id);
            $venue->delete();
            return redirect()->route('event.venues')->with('success', 'Venue deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('event.venues')->with('error', 'Failed to delete venue.');
        }
    }

    // Event Categories Handler (CRUD)
    public function listCategories()
    {
        $categories = EventCategory::all();
        return view('pages.event.category.view', ['categories' => $categories]);
    }
    public function viewAddCategory()
    {
        return view('pages.event.category.add');
    }
    public function doAddCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        try {
            $imageName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('images/event/category'), $imageName);
            $category = new EventCategory();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->image = $imageName;
            $category->save();
            return redirect()->route('event.categories')->with('success', 'Category added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('event.category.add')->with('error', 'Failed to add category.');
        }
    }
    public function viewEditCategory($id)
    {
        $category = EventCategory::find($id);
        return view('pages.event.category.edit', ['category' => $category]);
    }
    public function doEditCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        try {
            $category = EventCategory::find($id);
            $category->name = $request->name;
            $category->description = $request->description;
            if ($request->file) {
                // Delete old image
                if ($category->image) {
                    unlink(public_path('images/event/category/' . $category->image));
                }
                $imageName = time() . '.' . $request->file->extension();
                $request->file->move(public_path('images/event/category'), $imageName);
                $category->image = $imageName;
            }
            $category->save();
            return redirect()->route('event.categories')->with('success', 'Category edited successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('event.category.edit', ['id' => $id])->with('error', 'Failed to edit category.');
        }
    }
    public function doDeleteCategory($id)
    {
        try {
            $category = EventCategory::find($id);
            // Delete old image
            if ($category->image) {
                unlink(public_path('images/event/category/' . $category->image));
            }
            $category->delete();
            return redirect()->route('event.categories')->with('success', 'Category deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('event.categories')->with('error', 'Failed to delete category.');
        }
    }
}
