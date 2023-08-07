<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryApiController extends Controller
{
    // Function to get all images
    public function getAllImages()
    {
        $images = \App\Models\Gallery::all();
        return response()->json($images);
    }
}
