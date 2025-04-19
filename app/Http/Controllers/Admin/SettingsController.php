<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            
            if ($setting) {
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    // Delete old image if exists
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }
                    
                    // Store new image
                    $path = $request->file($key)->store('settings', 'public');
                    $value = $path;
                } elseif ($setting->type === 'json') {
                    $value = json_decode($value, true);
                }
                
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
} 