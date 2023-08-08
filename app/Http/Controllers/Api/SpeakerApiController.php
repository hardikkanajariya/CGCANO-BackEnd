<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speakers;

class SpeakerApiController extends Controller
{
    public function getAllSpeakers()
    {
        $speakers = Speakers::all();
        foreach ($speakers as $speaker) {
            if (strpos($speaker->image, 'http') != 0) {
                $speaker->image = url('images/speaker/' . $speaker->image);
            }
        }
        return response()->json($speakers);
    }
}
