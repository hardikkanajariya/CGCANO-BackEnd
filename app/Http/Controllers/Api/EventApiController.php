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
//                'event_thumbnail' => url('images/event/thumbnail/' . $event->thumbnail),
                'event_thumbnail' => $event->thumbnail,
                'speaker_name' => $event->speaker->name,
                // 'speaker_image' => url('images/speaker/'.$event->speaker->image),
                'speaker_image' => $event->speaker->image,
                'slug' => $event->slug,
            ];
        }
        return response()->json($response);
    }

    // Function to get Event Detail by ID
    public function getEventDetail($slug)
    {
        $event = Events::where('slug', $slug)->first();
        $urls = [];
        foreach (json_decode($event->gallery) as $gallery) {
            // If $gallery is start with http, then use $gallery as it is
            if (strpos($gallery, 'http') === 0) {
                $urls[] = $gallery;
                continue;
            }
            $urls[] = url('images/event/gallery/' . $gallery);
        }
        // if event thumbnail is start with http, then use $event->thumbnail as it is
        if (strpos($event->thumbnail, 'http') != 0) {
            $event->thumbnail = url('images/event/thumbnail/' . $event->thumbnail);
        }
        $response = [
            'id' => $event->id,
            'title' => $event->title,
            'slug' => $event->slug,
            'event_date' => Carbon::parse($event->event_date)->format('d M Y'),
            'event_thumbnail' => $event->thumbnail,
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
