<?php

namespace App\Models;

use App\Enums\StatesEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
protected $fillable = ["car_id","user_id","reservation_date","state"];

public function car(): BelongsTo
{
    return $this->belongsTo(Car::class);
}
public function user(): BelongsTo{
    return $this->belongsTo(User::class);
}
protected $casts = [
    'state' => StatesEnum::class,
];

}
