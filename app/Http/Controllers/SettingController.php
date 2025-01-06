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

}
