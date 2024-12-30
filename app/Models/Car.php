<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
