<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Events;
use http\Client\Request;
use Illuminate\Support\Carbon;

class EventApiController extends Controller
{
    // Function to get All Event List
    public function getAll()
    {
        $events = Events::where('status', 1)->get();
        $response = [];
        foreach ($events as $event) {
            $response[] = [
                'id' => $event->id,
                'title' => $event->title,
                'event_date' => Carbon::parse($event->event_date)->format('d M Y'),
                'event_thumbnail' => url('images/event/thumbnail/' . $event->thumbnail),
                'speaker_name' => $event->speaker->name,
                // 'speaker_image' => url('images/speaker/'.$event->speaker->image),
                'speaker_image' => $event->speaker->image,
            ];
        }
        return response()->json($response);
    }

    // Function to get Event Detail by ID
    public function getEventDetail($name)
    {
        $event = Events::where('title', $name)->first();
        $urls = [];
        foreach (json_decode($event->gallery) as $gallery) {
            $urls[] = url('images/event/gallery/' . $gallery);
        }
        $response = [
            'id' => $event->id,
            'title' => $event->title,
            'event_date' => Carbon::parse($event->event_date)->format('d M Y'),
            'event_thumbnail' => url('images/event/thumbnail/' . $event->thumbnail),
            'speaker' => $event->speaker,
            'description' => $event->description,
            'address' => $event->venue->address,
            'gallery' => $urls,
            'youtube' => $event->youtube,
            'website' => $event->website,
            'phone' => $event->contact_phone,
            'email' => $event->contact_email,
            'twitter' => $event->twitter,
            'facebook' => $event->facebook,
            'instagram' => $event->instagram,
            'linkedin' => $event->linkedin,
        ];
        return response()->json($response);
    }

}
