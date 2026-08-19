<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function equipments()
{
    return $this->hasMany(Equipment::class);
}
}
