<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.pages.dashboard');
    }

    public function InitialFormInteres()
    {
        $enquiry = UserInterest::latest()->paginate(10);
        return view('admin.pages.enquiry_list', compact('enquiry'));
    }

    public function deleteEnquiry(Request $request, $id)
    {

        $enquiry = UserInterest::findOrFail($id);

        try {

            $enquiry->delete();

            return redirect()->back()->with('success', 'Enquiry deleted successfully.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to delete enquiry. Please try again.');
        }
    }

    // VIDEO UPLOAD

    public function videoUpload()
    {
        $setting = Setting::first();
        return view('admin.pages.video_upload', compact('setting'));
    }



    public function uploadVideo(Request $request)
    {
        Log::info('Video upload initiated.');
    
        // Validate the file
        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:20480', // Max size 20MB
        ]);
        
        Log::info('File validation passed.');
    
        // Check if the file is present in the request
        if ($request->hasFile('video')) {
            Log::info('File is present in the request.');
    
            // Get the file
            $videoFile = $request->file('video');
    
            Log::info('File name: ' . $videoFile->getClientOriginalName());
            Log::info('File size: ' . $videoFile->getSize());
    
            // Continue with the rest of the upload process...
        } else {
            Log::error('No video file found in the request.');
            return response()->json(['success' => false, 'message' => 'No video file found.'], 500);
        }
    }
    
}
