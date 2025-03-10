<?php

namespace App\Http\Controllers;

use App\Models\LandingPageContent;
use App\Models\PageContent;
use App\Models\Setting;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function home()
    {
        // $content = PageContent::where('page_name', 'home')->get();
        $content = PageContent::where('page_name', 'home')->first();
        // return $content;
        // if (!$content) {
        //     abort(404, 'Page content not found');
        // }

        return view('user.pages.home', compact('content'));
    }


    public function storeInterest(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
            ]);

            UserInterest::create($validated);

            return response()->json(['message' => 'Your interest submitted successfully!', 'status' => 'success'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error storing user interest: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while submitting your interest.'], 500);
        }
    }

    public function showTraining()
    {
        $settings = Setting::first();

        $content = LandingPageContent::first();

        return view('user.pages.training_show', compact('settings', 'content'));
    }
}
