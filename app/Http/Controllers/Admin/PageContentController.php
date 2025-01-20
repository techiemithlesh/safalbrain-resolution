<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageContent;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function edit()
    {
        $content = PageContent::firstOrCreate(
            ['page_name' => 'home'],
            [
                'subtitle' => "If you're not a coach, course creator, content creator, consultant...",
                'non_target_text' => "Then this training will not be valuable for you.",
                'main_title' => "How We Generated 173 Clients Last Month Totalling 1.98 Cr. in Sales Using The",
                'highlighted_text' => "Legacy Flywheel Matrix & Latest AI Technology"
            ]
        );

        return view('admin.pages.content_edit', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'subtitle' => 'required|string',
            'non_target_text' => 'required|string',
            'main_title' => 'required|string',
            'highlighted_text' => 'required|string',
        ]);

        $content = PageContent::firstOrCreate(['page_name' => 'training']);
        $content->update($request->all());

        return redirect()->back()->with('success', 'Content updated successfully!');
    }


    public function trainingPageEdit(){

        $content = LandingPageContent::firstOrCreate(
            ['id' => 1],
            [
                'main_title' => 'How We Generated High-Ticket Clients',
                'subtitle' => 'Legacy Flywheel Matrix & Latest AI Technology',
                'getting_started_title' => 'How to get started',
                'steps' => [
                    [
                        'title' => 'Watch the Complete Video',
                        'description' => 'Learn about our proven methodology and success stories'
                    ],
                    [
                        'title' => 'Book a Strategy Call',
                        'description' => 'Schedule a one-on-one session with our experts'
                    ],
                    [
                        'title' => 'Implement the Strategy',
                        'description' => 'Follow our proven framework to scale your business'
                    ]
                ],
                'book_call_button_text' => 'Book a Call Now',
            ]
        );

        return view('admin.pages.edit_training_page', compact('content'));
    }

    public function trainingPageUpdate(Request $request)
    {
        $validated = $request->validate([
            'main_title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'getting_started_title' => 'required|string|max:255',
            'steps' => 'required|array',
            'steps.*.title' => 'required|string|max:255',
            'steps.*.description' => 'required|string',
            'book_call_button_text' => 'required|string|max:255',
        ]);

        $content = LandingPageContent::firstOrFail();
        $content->update($validated);

        return redirect()->back()->with('success', 'Landing page content updated successfully');
    }
}