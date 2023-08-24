<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TicketCombo;
use App\Models\EventCategory;
use App\Models\EventList;
use App\Models\Gallery;
use App\Models\MemberShip;
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
            $sponsor->logo = url('images/sponsor/' . $sponsor->logo);
        }
        return response()->json($sponsors);
    }

    // Function to get all events
    public function getAllEvents()
    {
        $events = EventList::where('status', 1)->get();
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

    // Function to get all offers
    public function getAllOffers()
    {
        $offers = TicketCombo::all();
        $response = [];
        foreach($offers as $offer) {
            $response[] = [
                'id' => $offer->id,
                'name' => $offer->name,
                'description' => $offer->description,
                'price' => $offer->price,
                'image' => url('images/combos/' . $offer->image),
                'date' => Carbon::parse($offer->created_at)->format('d M Y'),
            ];
        }
        return response()->json($response);
    }

    // Function to get offer details by id
    public function getOfferDetails($id)
    {
        $offer = TicketCombo::find($id);
        if (!$offer) {
            return response()->json(['error' => 'Offer not found'], 404);
        }

        $events = [];
        foreach(json_decode($offer->event_id) as $event) {
            $event = EventList::find($event);
            if (!$event){
                continue;
            }
            $events[] = [
                'id' => $event->id,
                'title' => $event->title,
                'event_date' => Carbon::parse($event->start)->format('d M Y'),
                'event_thumbnail' => url('images/event/thumbnail/' . $event->thumbnail),
                'speaker_name' => $event->speaker->name,
                'speaker_image' => url('images/speaker/' . $event->speaker->image),
                'slug' => $event->slug,
            ];
        }
        $response = [
            'id' => $offer->id,
            'name' => $offer->name,
            'description' => $offer->description,
            'price' => $offer->price,
            'image' => url('images/combos/' . $offer->image),
            'date' => Carbon::parse($offer->created_at)->format('d M Y'),
            'events' => $events,
        ];
        return response()->json($response);
    }

    // Function to get all packages
    public function getAllPackages()
    {
        $packages = MemberShip::where('status', 1)->get();
        return response()->json($packages);
    }

}
