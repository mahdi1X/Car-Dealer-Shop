<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        "name",
        "icon",
    ];


    /**
     * Get the cars associated with the brand.
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
