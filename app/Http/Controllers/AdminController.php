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

        try {
            // Validate the file
            $request->validate([
                'video' => 'required|mimes:mp4,mov,avi,wmv|max:20480',
            ]);

            Log::info('File validation passed.');

            if ($request->hasFile('video')) {
                Log::info('File is present in the request.');

                $videoFile = $request->file('video');

                Log::info('File name: ' . $videoFile->getClientOriginalName());
                Log::info('File size: ' . $videoFile->getSize());

                // Generate unique filename
                $fileName = time() . '_' . $videoFile->getClientOriginalName();

                // Define upload path
                $uploadPath = public_path('uploads/videos');

                // Create directory if it doesn't exist
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Move the file
                $videoFile->move($uploadPath, $fileName);

                // Update or create settings
                $setting = Setting::firstOrCreate([], [
                    'video_link' => 'uploads/videos/' . $fileName
                ]);

                // Update video link if setting already existed
                $setting->video_link = 'uploads/videos/' . $fileName;
                $setting->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Video uploaded successfully!',
                    'path' => asset('uploads/videos/' . $fileName)
                ]);
            } else {
                Log::error('No video file found in the request.');
                return response()->json([
                    'success' => false,
                    'message' => 'No video file found.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error uploading video: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading video: ' . $e->getMessage()
            ], 500);
        }
    }

   

}
