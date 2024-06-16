<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\VehicleCategory;
use App\Http\Requests\VehicleCategoryRequest;
use Carbon\Carbon;
use App\Helpers\ImageHelper;

class VehicleCategoryController extends Controller
{
    public function index(Request $request) 
    {
        $allVehicleCategories = VehicleCategory::orderBy('created_at', 'asc')->get();

        return view('admin.vehicle-category', compact('allVehicleCategories'));
    }

    public function store(VehicleCategoryRequest $request) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $vehicleCategory = new VehicleCategory();
        $vehicleCategory->name = $validated['name'];
        $vehicleCategory->size = $validated['size'];

        $imageLink = $this->handleImageUpload($request);
        $vehicleCategory->icon_link = $imageLink;

        $vehicleCategory->created_at = $current_timestamp;
        $vehicleCategory->updated_at = $current_timestamp;
        $vehicleCategory->save();

        return redirect()->route('vehicle-categories.index')->with('success', 'Vehicle category created successfully.');
    }

    public function update(VehicleCategoryRequest $request, $id) 
    {
        $validated = $request->validated();

        $validated['updated_at'] = Carbon::now();

        $vehicleCategory = VehicleCategory::find($id);

        if ($vehicleCategory) {
            logger("Category to update:", [$vehicleCategory->name]);
            if ($request->hasFile('image')) {
                ImageHelper::handleImageDelete($vehicleCategory->icon_link);
                $validated['icon_link'] = $this->handleImageUpload($request);
            }

            $vehicleCategory->update($validated);
            return redirect()->route('vehicle-categories.index')->with('success', 'Vehicle category updated successfully');
        }

        return redirect()->route('vehicle-categories.index')->with('error', 'Vehicle category not found');
    }

    public function destroy($id) 
    {
        $vehicleCategory = VehicleCategory::find($id);

        if ($vehicleCategory) {
            ImageHelper::handleImageDelete($vehicleCategory->icon_link);
            // $this->handleImageDelete($vehicleCategory->icon_link);
            $vehicleCategory->delete();

            return redirect()->route('vehicle-categories.index')->with('success', 'Vehicle category deleted successfully');
        }
        
        return redirect()->route('vehicle-categories.index')->with('error', 'Vehicle category not found');
    }

    public function handleImageUpload(VehicleCategoryRequest $request)
    {
        $folder = 'vehicle-category';
        $imageLink = '/images/defaultIcon.svg';

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
