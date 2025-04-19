<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyStatus;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with(['propertyType', 'propertyStatus', 'images'])
            ->latest()
            ->paginate(9);
            
        $propertyTypes = PropertyType::all();
        $propertyStatuses = PropertyStatus::all();

        return view('properties.index', compact('properties', 'propertyTypes', 'propertyStatuses'));
    }

    public function show(Property $property)
    {
        if ($property->is_archived) {
            abort(404);
        }

        $property->load(['propertyType', 'propertyStatus', 'images']);
        return view('properties.show', compact('property'));
    }
} 