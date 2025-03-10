<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function getPrice()
    {
        return DB::table('settings')->select('price')->first();
    }


    public function setPrice()
    {
        $price = $this->getPrice();


        return view('admin.pages.setting.setprice', compact('price'));
    }

    public function updatePrice(Request $request)
    {

        $setting = Setting::findOrFail(1);

        $request->validate([
            'price' => 'required|numeric',
        ]);

        $setting->update([
            'price' => $request->price,
        ]);

        return redirect()->route('setprice')->with('success', 'Price updated successfully.');
    }


    public function showLogoForm()
    {
        $setting = Setting::first();
        // return $logo;
        return view('admin.pages.setting.setlogo', compact('setting'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_heading' => 'nullable|string|max:255',
        ]);

        // Fetch the first record or create a new one
        $logo = Setting::first() ?? new Setting();

        if ($request->hasFile('logo')) {
            // Delete previous logo if exists
            if ($logo->logo_path && file_exists(public_path($logo->logo_path))) {
                unlink(public_path($logo->logo_path));
            }

            // Get file extension and generate unique name
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Move file to public/uploads/logo directory
            $file->move(public_path('uploads/logo'), $filename);

            // Store file path in database
            $logo->logo = 'uploads/logo/' . $filename;
        }

        $logo->logo_heading = $request->logo_heading;
        $logo->save();

        return back()->with('success', 'Logo updated successfully.');
    }


}
