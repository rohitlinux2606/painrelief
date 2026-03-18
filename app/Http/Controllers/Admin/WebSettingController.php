<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = WebSetting::first();

        return view('admin.pages.web_settings.index', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'map_link' => 'nullable|string',
            'shipping_charge' => 'nullable|numeric|min:0',
            'free_shipping_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        try {
            $setting = WebSetting::first() ?? new WebSetting;

            $data = $request->except(['_token', 'logo']);

            if ($request->hasFile('logo')) {
                // If there's an existing logo, we delete it
                if ($setting->logo) {
                    // Using assuming global deleteFile helper
                    if (function_exists('deleteFile')) {
                        deleteFile($setting->logo);
                    } elseif (\Illuminate\Support\Facades\File::exists(public_path($setting->logo))) {
                        \Illuminate\Support\Facades\File::delete(public_path($setting->logo));
                    }
                }

                // Using assuming global uploadFile helper
                if (function_exists('uploadFile')) {
                    $data['logo'] = uploadFile($request->file('logo'), 'uploads/settings/');
                } else {
                    $path = $request->file('logo')->store('uploads/settings', 'public');
                    $data['logo'] = 'storage/'.$path;
                }
            }

            $setting->fill($data);
            $setting->save();

            return redirect()->back()->with('success', 'Web Settings updated successfully.');
        } catch (\Exception $e) {
            Log::error('Web Settings Update Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
        }
    }
}
