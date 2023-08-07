<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speakers;
use Illuminate\Http\Request;

class SpeakerApiController extends Controller
{
    public function getAllSpeakers()
    {
        $speakers = Speakers::all();
        return response()->json($speakers);
    }
}
