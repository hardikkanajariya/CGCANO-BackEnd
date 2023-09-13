<?php

namespace App\Http\Controllers;

use App\Models\VolunteersResume as Resume;
use Exception;
use Illuminate\Http\Request;

class VolunteersResume extends Controller
{
    // Function to View All Volunteers Resume
    public function listResume()
    {
        $list = Resume::all();
        return view('pages.pos.resume')->with('list', $list);
    }

    // Function to delete Status
    public function doDelete($id)
    {
        $list = Resume::find($id);
        $list->delete();
        return redirect()->back()->with('success', 'Resume Deleted Successfully');
    }

    // Function to Mark as Approved
    public function markAsApproved($id)
    {
        $list = Resume::find($id);
        $list->status = 'Approved';
        $list->save();
        return redirect()->back()->with('success', 'Resume Approved Successfully');
    }

    // Function to Mark as Rejected
    public function markAsRejected($id)
    {
        $list = Resume::find($id);
        $list->status = 'Rejected';
        $list->save();
        return redirect()->back()->with('success', 'Resume Rejected Successfully');
    }

    // Function to create a new Résumé
    public function createApplication(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'message' => 'required',
            'file' => 'required',
        ]);

        try {
            $resume = new Resume();

            $time = time();
            $name = $request->name;
            $filename = "{$name}_{$time}.{$request->file->extension()}";
            $request->file->move(public_path('uploads/resume/'), $filename);

            $resume->file = $filename;
            $resume->name = $request->name;
            $resume->email = $request->email;
            $resume->phone = $request->phone;
            $resume->address = $request->address;
            $resume->message = $request->message;
            $resume->status = 'Pending';
            $resume->save();
            // Return Api Response
            return response()->json([
                'status' => 'success',
                'message' => 'Application Submitted Successfully',
            ]);
        } catch (Exception $e) {
            // Return Api Response
            return response()->json([
                'status' => 'error',
                'message' => 'Error Submitting Application',
            ]);
        }
    }

    // Function to upload resume
    public function uploadResume(Request $request, $id)
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            $resume = Resume::find($id);

            // Generate filename with an extension
            $time = time();
            $name = $resume->name;
            $filename = "{$name}_{$time}.{$request->file->extension()}";
            $request->file->move(public_path('uploads/resume/'), $filename);

            $resume->file = $filename;
            $resume->save();
            // Return Api Response
            return response()->json([
                'status' => 'success',
                'message' => 'Resume Uploaded Successfully',
            ]);
        } catch (Exception $e) {
            // Return Api Response
            return response()->json([
                'status' => 'error',
                'message' => 'Error Uploading Resume',
            ]);
        }
    }
}
