<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{

    protected $fillable = [
        "name",
        "color",
        "brand_id",
        "year",
        "price",
        "length",
        "image",
        "created_by_id",
        "km_recorded"
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the brand associated with the car.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function Reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
