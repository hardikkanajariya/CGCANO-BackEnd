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
        // if image is start with http, then use $image->image as it is
        foreach ($images as $image) {
            if (strpos($image->path, 'http') != 0) {
                $image->path = url('images/gallery/' . $image->image);
            }
        }
        return response()->json($images);
    }
}
