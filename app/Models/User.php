<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'payment_method',
        'role',
        'region',
        'profile_picture',
        'is_banned',
        'ban_reason',
        'banned_until',
    ];




    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned_until' => 'datetime', // add this
            'is_banned' => 'boolean',
        ];
    }
    public function banDurationText(): string
    {
        if (!$this->isCurrentlyBanned()) {
            return '';
        }

        if ($this->banned_until) {
            $daysLeft = now()->diffInDays($this->banned_until);
            return "Temporary ban: $daysLeft day(s) remaining.";
        }

        return "Permanent ban.";
    }


    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedCars()
    {
        return $this->belongsToMany(Car::class, 'likes')->withPivot('like')->withTimestamps();
    }
    // in User.php model
    public function cars()
    {
        return $this->hasMany(Car::class, 'created_by_id');
    }
    public function managers(): HasMany
    {
        return $this->hasMany(User::class, 'managed_by');
    }

    // A manager is managed by one admin
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'managed_by');
    }
    public function isCurrentlyBanned()
    {
        if ($this->banned_until && now()->lessThan($this->banned_until)) {
            return true; // Temporarily banned
        }

        if ($this->is_banned && is_null($this->banned_until)) {
            return true; // Permanently banned
        }

        return false;
    }





}
