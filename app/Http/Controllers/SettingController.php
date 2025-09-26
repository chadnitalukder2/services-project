<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array 
    {
        return [
            new Middleware('permission:view settings', only: ['index', 'show']),
        ];
    }
    public function index()
    {
        $setting = Setting::getSettings();
        return view('backend.settings.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'currency' => 'nullable|string|max:10',
            'currency_position' => 'nullable|in:left,right',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'message' => 'nullable|string'
        ]);

        $data = $request->except(['logo']);

        if ($request->hasFile('logo')) {
            $currentSetting = Setting::first();

            if ($currentSetting && $currentSetting->logo) {
                Storage::disk('public')->delete($currentSetting->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        Setting::updateOrCreateSettings($data);

            return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
