<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    
protected $fillable = [
    'user_id',
    'category_id',
    'name',
    'description',
    'price_per_hour',
    'photo',
    'stock_status'
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function category()
{
    return $this->belongsTo(Category::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
