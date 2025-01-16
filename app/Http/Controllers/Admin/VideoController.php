<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function index()
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
                'video' => 'required|mimes:mp4,mov,avi,wmv|max:30480', // Max size 20MB
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
                
                // Remove old video if exists
                $setting = Setting::first();
                if ($setting && $setting->video_link) {
                    $oldVideoPath = public_path($setting->video_link);
                    if (file_exists($oldVideoPath)) {
                        unlink($oldVideoPath);
                    }
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