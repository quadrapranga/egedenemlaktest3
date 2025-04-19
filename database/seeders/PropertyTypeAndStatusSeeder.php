<?php

namespace Database\Seeders;

use App\Models\PropertyStatus;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeAndStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create property types
        $propertyTypes = [
            'Apartment',
            'House',
            'Villa',
            'Land',
            'Commercial',
            'Office',
            'Studio',
            'Penthouse',
            'Duplex',
            'Farmhouse'
        ];

        foreach ($propertyTypes as $type) {
            PropertyType::create(['name' => $type]);
        }

        // Create property statuses
        $propertyStatuses = [
            'For Sale',
            'For Rent',
            'Sold',
            'Rented',
            'Under Contract',
            'Coming Soon'
        ];

        foreach ($propertyStatuses as $status) {
            PropertyStatus::create(['name' => $status]);
        }
    }
} 