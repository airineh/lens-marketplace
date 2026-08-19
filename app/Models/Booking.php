<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'user_id',
    'equipment_id',
    'start_time',
    'end_time',
    'status',
    'total_price',
    'returned_at',
    'late_fee',
    'late_fee_status',
    'platform_fee',
    'commission_percentage',
    'commission_amount',
    'owner_income',
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function equipment()
{
    return $this->belongsTo(Equipment::class);
}

public function payment()
{
    return $this->hasOne(Payment::class);
}
}
