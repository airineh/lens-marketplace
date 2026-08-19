<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $fillable = [
        'commission_percentage',
        'bank_name',
        'bank_account_number',
        'bank_account_name'
    ];
}