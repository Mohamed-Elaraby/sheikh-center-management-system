<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = ['name'];

    public function carSizes()
    {
        return $this->hasMany(CarSize::class);
    }

    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
