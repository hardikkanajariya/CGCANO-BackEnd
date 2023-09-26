<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($file)
    {
        // Define the path to the file in the storage directory
        $filePath = storage_path('app/CGCANO team/' . $file);

        // Check if the file exists
        if (file_exists($filePath)) {
            // Get the original name of the file
            $originalName = basename($filePath);

            // Generate a response to force download the file
            return response()->download($filePath, $originalName);
        } else {
            // File isn't found
            abort(404);
        }
    }

}
