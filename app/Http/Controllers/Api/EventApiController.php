<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Support\Carbon;

class EventApiController extends Controller
{
    // Function to get Event Detail by ID
    public function getEventDetail($slug)
    {
        $event = Events::where('slug', $slug)->first();
        $urls = [];
        foreach (json_decode($event->gallery) as $gallery) {
            $urls[] = url('images/event/gallery/' . $gallery);
        }
        $event->thumbnail = url('images/event/thumbnail/' . $event->thumbnail);
        $speaker = $event->speaker;
        $speaker->image = url('images/speaker/' . $speaker->image);
        $response = [
            'id' => $event->id,
            'title' => $event->title,
            'slug' => $event->slug,
            'event_date' => Carbon::parse($event->start)->format('d M Y'),
            'event_thumbnail' => $event->thumbnail,
            'speaker' => $speaker,
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
