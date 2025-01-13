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
    ];


    /**
     * Get the brand associated with the car.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function Reservation(): HasMany{
        return $this->hasMany(Reservation::class);
    }
}
