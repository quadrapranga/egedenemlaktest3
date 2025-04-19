<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::with(['propertyType', 'propertyStatus'])
            ->latest()
            ->paginate(10);

        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propertyTypes = PropertyType::all();
        $propertyStatuses = PropertyStatus::all();

        return view('admin.properties.create', compact('propertyTypes', 'propertyStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'property_status_id' => 'required|exists:property_statuses,id',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = auth()->id();

        $property = Property::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create([
                    'image_path' => $path,
                    'order' => $index
                ]);
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $propertyTypes = PropertyType::all();
        $propertyStatuses = PropertyStatus::all();

        return view('admin.properties.edit', compact('property', 'propertyTypes', 'propertyStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'property_status_id' => 'required|exists:property_statuses,id',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $property->images()->delete();

            // Store new images
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create([
                    'image_path' => $path,
                    'order' => $index
                ]);
            }
        }

        $property->update($validated);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        // Delete all property images
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $property->delete();

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    public function archive(Property $property)
    {
        $property->update(['is_archived' => true]);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property archived successfully.');
    }

    public function unarchive(Property $property)
    {
        $property->update(['is_archived' => false]);

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property unarchived successfully.');
    }
}
