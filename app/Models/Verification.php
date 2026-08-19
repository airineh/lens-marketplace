<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $fillable = [
    'user_id',
    'sim_photo',
    'selfie_photo',
    'portfolio_link',
    'status',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}