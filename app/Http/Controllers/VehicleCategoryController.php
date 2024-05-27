<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\VehicleCategory;
use App\Http\Requests\VehicleCategoryRequest;
use App\Http\Resources\VehicleCategoryResource;
use Carbon\Carbon;

class VehicleCategoryController extends Controller
{
    public function index(Request $request) 
    {
        $allVehicleCategories = VehicleCategory::all();

        if(!$allVehicleCategories->isEmpty()) {
            return VehicleCategoryResource::collection($allVehicleCategories);
        }

        return response()->json(['message' => 'There are no available vehicle categories'], 404);
    }

    public function store(VehicleCategoryRequest $request) 
    {
        $validated = $request->validated();

        logger("The request: " . $request);

        $current_timestamp = Carbon::now();

        $vehicleCategory = new VehicleCategory();
        $vehicleCategory->name = $validated['name'];

        $imageLink = $this->handleImageUpload($request, 'vehiclecategory');
        $vehicleCategory->icon_link = $imageLink;

        $vehicleCategory->created_at = $current_timestamp;
        $vehicleCategory->updated_at = $current_timestamp;
        $vehicleCategory->save();

        return response()->json(['message' => 'Vehicle category created successfully'], 200);
    }

    public function show($id) 
    {
        $vehicleCategory = VehicleCategory::find($id);

        if ($vehicleCategory) {
            return new VehicleCategoryResource($vehicleCategory);
        }

        return response()->json(['message' => 'Vehicle category not found'], 404);
    }

    public function update(VehicleCategoryRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $vehicleCategory = VehicleCategory::find($id);

        if ($vehicleCategory) {
            if($request->hasFile('image')) {
                $filePath = 'images/vehiclecategory/' . $vehicleCategory->icon_link;
                $defaultIcon = config('app.url') . '/storage/images/vehiclecategory/defaultIcon.png';
                if (Storage::disk('public')->exists($filePath) && $vehicleCategory->icon_link != $defaultIcon) {
                    Storage::disk('public')->delete($filePath);
                }
                $imageLink = $this->handleImageUpload($request, 'vehiclecategory');
                $validated['icon_link'] = $imageLink;
            }

            $vehicleCategory->update($validated);

            return response()->json(['message' => 'Vehicle category updated successfully'], 200);
        }

        return response()->json(['message' => 'Vehicle category not found'], 404);
    }

    public function destroy($id) 
    {
        $vehicleCategory = VehicleCategory::find($id);

        if ($vehicleCategory) {
            $filePath = 'images/vehiclecategory/' . $vehicleCategory->icon_link;
            $defaultIcon = config('app.url') . '/storage/images/vehiclecategory/defaultIcon.png';
            if (Storage::disk('public')->exists($filePath) && $vehicleCategory->icon_link != $defaultIcon) {
                Storage::disk('public')->delete($filePath);
            }
            $vehicleCategory->delete();

            return response()->json(['message' => 'Vehicle category deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Vehicle category not found'], 404);
    }

    private function handleImageUpload(VehicleCategoryRequest $request, $folder)
    {
        $imageLink = config('app.url') . '/storage/images/' . $folder . '/defaultIcon.png';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '_' . $request->name . '.' . $image->getClientOriginalExtension();

            $storagePath = 'public/images' . $folder . '/';

            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }

            $image->storeAs($storagePath, $imageName);

            $imageLink = config('app.url') . '/storage/images/' . $folder . '/' . $imageName;
        }

        return $imageLink;
    }
}
