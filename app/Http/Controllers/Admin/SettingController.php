<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\RegisterAgencyRequest;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class SettingController extends Controller
{
    public function registerAgencyDetails(RegisterAgencyRequest $request)
    {
        $validated = $request->validated();
        $keys = ['agency', 'address', 'email', 'logo'];

        foreach($keys as $key) 
        {
            $setting = new Setting();
            $setting->label = $key;

            if(strcmp($key, 'logo') == 0) {
                $imageLink = $this->handleImageUpload($request);
                $setting->value = $imageLink;
            }
            else {
                $setting->value = $validated[$key];
            }

            $setting->save();
        }

        return response()->json(['message' => 'Agency details registered successfully'], 200);
    }

    public function updateAgencyDetails(RegisterAgencyRequest $request) 
    {
        $validated = $request->validated();
        $keys = ['agency', 'address', 'email', 'image'];

        foreach($keys as $key) 
        {
            if(array_key_exists($key, $validated)) {
                if(strcmp($key, 'image') == 0) {
                    $key = 'logo';
                    $setting = Setting::where('label', $key)->first();
                    if ($request->hasFile('image')) {
                        ImageHelper::handleImageDelete($setting->value);
                        $imageLink = $this->handleImageUpload($request);
                        $setting->value = $imageLink;
                        $setting->save();
                    }
                }
                else {
                    $setting = Setting::where('label', $key)->first();
                    $setting->value = $validated[$key];
                    $setting->save();
                }
            }
        }

        return response()->json(['message' => 'Agency details updated successfully'], 200);
    }

    public function handleImageUpload(RegisterAgencyRequest $request)
    {
        $folder = 'agency-logo';
        $imageLink = '/images/CamWiGo_logo.png';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $storagePath = 'public/images/' . $folder . '/';

            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }

            $image->storeAs($storagePath, $imageName);

            $imageLink = '/images/' . $folder . '/' . $imageName;
        }

        return $imageLink;
    }
}
