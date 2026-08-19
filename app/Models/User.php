<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'portfolio_link',
        'profile_photo',
        'verification_status',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function verification()
    {
        return $this->hasOne(Verification::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}