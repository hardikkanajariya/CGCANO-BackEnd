<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Models\Events;
use App\Models\Gallery;
use App\Models\Speakers;
use App\Models\Sponsors;
use Illuminate\Support\Carbon;

class CommonApiController extends Controller
{
    // Function to get all speakers
    public function getAllSpeakers()
    {
        $speakers = Speakers::all();
        foreach ($speakers as $speaker) {
            $speaker->image = url('images/speaker/' . $speaker->image);
        }
        return response()->json($speakers);
    }

    // Function to get all galleries
    public function getAllGalleries()
    {
        $images = Gallery::all();
        // if image is start with http, then use $image->image as it is
        foreach ($images as $image) {
            $image->path = url('images/gallery/' . $image->path);
        }
        return response()->json($images);
    }

    // Function to get all categories
    public function getAllCategories()
    {
        $categories = EventCategory::all();
        foreach ($categories as $category) {
            $category->image = url('images/event/category/' . $category->image);
        }
        return response()->json($categories);
    }

    // Function to get all sponsors
    public function getAllSponsors()
    {
        $sponsors = Sponsors::all();
        foreach ($sponsors as $sponsor) {
            $sponsor->image = url('images/sponsor/' . $sponsor->image);
        }
        return response()->json($sponsors);
    }

    // Function to get all events
    public function getAllEvents()
    {
        $events = Events::where('status', 1)->get();
        $response = [];
        foreach ($events as $event) {
            $response[] = [
                'id' => $event->id,
                'title' => $event->title,
                'event_date' => Carbon::parse($event->start)->format('d M Y'),
                'event_thumbnail' => url('images/event/thumbnail/' . $event->thumbnail),
                'speaker_name' => $event->speaker->name,
                'speaker_image' => url('images/speaker/' . $event->speaker->image),
                'slug' => $event->slug,
            ];
        }
        return response()->json($response);
    }

}
