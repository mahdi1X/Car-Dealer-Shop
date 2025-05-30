<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        // Existing attributes
        "name",
        "color",
        "brand_id",
        "year",
        "price",
        "length",
        "image",
        "created_by_id",
        "km_recorded",

        // Basic & Performance Specs
        "transmission",
        "engine_type",
        "engine_size",
        "horsepower",
        "torque",
        "drivetrain",
        "fuel_type",
        "fuel_economy",

        // Features & Options
        "body_type",
        "seats",
        "doors",
        "interior_color",
        "features",        
        "safety_rating",

        // History & Condition
        "condition",
        "service_history", 
        "accident_history",
        "ownership_count",
        "registration_valid_till",

        // Location & Logistics
        "location",
        "delivery_available",
        "available_from",

        // Media & Documentation
        "video",
        "documents",        
        "gallery_images", 
    ];
    protected $casts = [
        'features' => 'array',
        'documents' => 'array',
        'gallery_images' => 'array',
    ];



    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withPivot('like')->withTimestamps();
    }
    public function profile(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
