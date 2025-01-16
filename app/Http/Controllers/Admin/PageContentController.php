<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    public function edit()
    {
        $content = PageContent::firstOrCreate(
            ['page_name' => 'training'],
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
}