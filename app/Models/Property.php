<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'property_type_id',
        'property_status_id',
        'price',
        'area',
        'bedrooms',
        'bathrooms',
        'location',
        'contact_number',
        'description',
        'user_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
    ];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function propertyStatus()
    {
        return $this->belongsTo(PropertyStatus::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }
}
