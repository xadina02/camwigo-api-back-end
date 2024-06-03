<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\VehicleCategory;
use App\Http\Requests\VehicleCategoryRequest;
use App\Http\Resources\VehicleCategoryResource;
use Carbon\Carbon;
use App\Helpers\ImageHelper;

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

        $current_timestamp = Carbon::now();

        $vehicleCategory = new VehicleCategory();
        $vehicleCategory->name = $validated['name'];
        $vehicleCategory->size = $validated['size'];

        $imageLink = $this->handleImageUpload($request);
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
        logger("DATA:", ["Raw Input" => $request->all(), "Request name" => [$request->input('name')], "Request size" => [$request->input('size')], "Request image" => [$request->file('image')]]);
        $validated = $request->validated();

        $validated['updated_at'] = Carbon::now();

        $vehicleCategory = VehicleCategory::find($id);

        if ($vehicleCategory) {
            logger("Category to update:", [$vehicleCategory->name]);
            if ($request->hasFile('image')) {
                logger("File present in request?", [true]);
                ImageHelper::handleImageDelete($vehicleCategory->icon_link);
                $validated['icon_link'] = $this->handleImageUpload($request);
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
            ImageHelper::handleImageDelete($vehicleCategory->icon_link);
            // $this->handleImageDelete($vehicleCategory->icon_link);
            $vehicleCategory->delete();

            return response()->json(['message' => 'Vehicle category deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Vehicle category not found'], 404);
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
