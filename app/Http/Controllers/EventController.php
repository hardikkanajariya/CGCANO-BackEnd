<?php

namespace App\Http\Controllers;

use App\Models\EventAmenities;
use App\Models\EventCategory;
use App\Models\Events;
use App\Models\Speakers;
use App\Models\Tickets;
use App\Models\Venues;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class EventController extends Controller
{
    // Event Handler (CRUD)
    public function list()
    {
        $events = Events::all();
        return view('pages.event.view', ['events' => $events]);
    }

    public function viewAdd()
    {
        $categories = EventCategory::all();
        $venues = Venues::all();
        $speakers = Speakers::all();
        return view('pages.event.add', ['categories' => $categories, 'venues' => $venues, 'speakers' => $speakers]);
    }

    public function doAdd(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:events',
            'description' => 'required',
            'category' => 'required|exists:event_categories,id',
            'venue' => 'required|exists:venues,id',
            'speaker' => 'required|exists:speakers,id',
            'start' => 'required|date|after:today',
            'end' => 'required|after:start',
            'duration' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'required|array',
            'gallery.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'tickets_available' => 'required|numeric',
            'audience_type' => 'nullable|array',
            'youtube' => 'nullable|url',
            'website' => 'nullable|url',
            'contact_phone' => 'nullable',
            'contact_email' => 'nullable|email',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);
        try {
            $event = new Events();
            $event->title = $request->title;

            // generate slug from title if slug is empty
            if ($request->slug == null) {
                $event->slug = strtolower(str_replace(' ', '-', $request->title));
            } else {
                $event->slug = $request->slug;
            }
            $event->description = $request->description;
            $event->category_id = $request->category;
            $event->venue_id = $request->venue;
            $event->speaker_id = $request->speaker;
            $event->start = $request->start;
            $event->end = $request->end;
            $event->duration = $request->duration;
            $imageName = time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move(public_path('images/event/thumbnail'), $imageName);
            $event->thumbnail = $imageName;
            // gallery
            $gallery = [];
            foreach ($request->gallery as $key => $value) {
                $galleryName = time() . $key . '.' . $value->extension();
                $value->move(public_path('images/event/gallery'), $galleryName);
                $gallery[] = $galleryName;
            }
            $event->gallery = json_encode($gallery);
            $event->tickets_available = '1';
            // If audience type is null, set it to empty array
            if ($request->audience_type == null) {
                $request->audience_type = [];
            }
            $event->audience_type = json_encode($request->audience_type);
            $event->youtube = $request->youtube;
            $event->website = $request->website;
            $event->contact_phone = $request->phone;
            $event->contact_email = $request->email;
            $event->twitter = $request->twitter;
            $event->instagram = $request->instagram;
            $event->facebook = $request->facebook;
            $event->linkedin = $request->linkedin;
            $event->save();
            return redirect()->route('event')->with('success', 'Event added successfully.');
        } catch (Exception $e) {
            // delete image and gallery
            $image_path = public_path('images') . '/event/thumbnail/' . $imageName;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            foreach ($gallery as $key => $value) {
                $image_path = public_path('images') . '/event/gallery/' . $value;
                if (file_exists($image_path)) {
                    @unlink($image_path);
                }
            }
            return redirect()->route('event.add')->with('error', 'Failed to add event.' . $e->getMessage());
        }
    }

    public function viewEdit($id)
    {
        $event = Events::find($id);
        $categories = EventCategory::all();
        $venues = Venues::all();
        $speakers = Speakers::all();
        return view('pages.event.edit', ['event' => $event, 'categories' => $categories, 'venues' => $venues, 'speakers' => $speakers]);
    }

    public function doEdit(Request $request, $id)
    {
        $event = Events::findOrFail($id);

        $request->validate([
            'id' => 'required|exists:events,id',
            'title' => 'required',
            'slug' => 'required|unique:events,slug,' . $id,
            'description' => 'required',
            'category' => 'required|exists:event_categories,id',
            'venue' => 'required|exists:venues,id',
            'speaker' => 'required|exists:speakers,id',
            'start' => 'required|date|after:today',
            'end' => 'required|after:start',
            'duration' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'tickets_available' => 'required|numeric',
            'youtube' => 'nullable|url',
            'website' => 'nullable|url',
            'contact_phone' => 'nullable',
            'contact_email' => 'nullable|email',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        try {
            $event->title = $request->title;
            // generate slug from title if slug is empty
            if ($request->slug == null) {
                $event->slug = strtolower(str_replace(' ', '-', $request->title));
            } else {
                $event->slug = $request->slug;
            }
            $event->description = $request->description;
            $event->category_id = $request->category;
            $event->venue_id = $request->venue;
            $event->speaker_id = $request->speaker;
            $event->start = $request->start;
            $event->end = $request->end;
            $event->duration = $request->duration;

            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                @unlink(public_path('images/event/thumbnail/' . $event->thumbnail));

                // Upload and save new thumbnail
                $imageName = time() . '.' . $request->thumbnail->extension();
                $request->thumbnail->move(public_path('images/event/thumbnail'), $imageName);
                $event->thumbnail = $imageName;
            }

            // Handle gallery upload
            if ($request->hasFile('gallery')) {
                // Delete old gallery
                $gallery = json_decode($event->gallery);
                foreach ($gallery as $key => $value) {
                    @unlink(public_path('images/event/gallery/' . $value));
                }

                // Upload and save new gallery
                $gallery = [];
                foreach ($request->gallery as $key => $value) {
                    $galleryName = time() . $key . '.' . $value->extension();
                    $value->move(public_path('images/event/gallery'), $galleryName);
                    $gallery[] = $galleryName;
                }
                $event->gallery = json_encode($gallery);
            }

            $event->tickets_available = '1';
//
//            if ($request->audience_type == null) {
//                $request->audience_type = [];
//            }
//            $event->audience_type = json_encode($request->audience_type);
            $event->youtube = $request->youtube;
            $event->website = $request->website;
            $event->contact_phone = $request->phone;
            $event->contact_email = $request->email;
            $event->twitter = $request->twitter;
            $event->instagram = $request->instagram;
            $event->facebook = $request->facebook;
            $event->linkedin = $request->linkedin;

            $event->save();

            return redirect()->route('event')->with('success', 'Event updated successfully');

        } catch (Exception $e) {
            // Delete thumbnail and gallery
            $image_path = public_path('images') . '/event/thumbnail/' . $imageName;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            $gallery = json_decode($event->gallery);
            foreach ($gallery as $key => $value) {
                $image_path = public_path('images') . '/event/gallery/' . $value;
                if (file_exists($image_path)) {
                    @unlink($image_path);
                }
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function doDelete($id)
    {
        try {
            $event = Events::find($id);
            // delete image
            $image_path = public_path('images') . '/event/thumbnail/' . $event->thumbnail;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            // delete gallery
            $gallery = json_decode($event->gallery);
            foreach ($gallery as $key => $value) {
                $image_path = public_path('images') . '/event/gallery/' . $value;
                if (file_exists($image_path)) {
                    @unlink($image_path);
                }
            }

            // Delete event tickets
            $tickets = Tickets::where('event_id', $id)->get();
            foreach ($tickets as $key => $value) {
                $value->delete();
            }
            $event->delete();
            return redirect()->route('event')->with('success', 'Event deleted successfully.');
        } catch (Throwable $th) {
            return redirect()->route('event')->with('error', 'Failed to delete event.');
        }
    }

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
        } catch (Exception $e) {
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
        } catch (Throwable $th) {
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
        } catch (Throwable $th) {
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
        } catch (Exception $e) {
            return redirect()->route('event.venue.add')->with('error', $e->getMessage());
        }
    }

    public function viewEditVenue($id)
    {
        $venue = Venues::find($id);
        $amenities = EventAmenities::all();
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
        } catch (Throwable $th) {
            return redirect()->route('event.venue.edit', ['id' => $id])->with('error', 'Failed to edit venue.');
        }
    }

    public function doDeleteVenue($id)
    {
        try {
            $venue = Venues::find($id);
            $venue->delete();
            return redirect()->route('event.venues')->with('success', 'Venue deleted successfully.');
        } catch (Throwable $th) {
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
        } catch (Exception $e) {
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
        } catch (Throwable $th) {
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
        } catch (Throwable $th) {
            return redirect()->route('event.categories')->with('error', 'Failed to delete category.');
        }
    }
}
