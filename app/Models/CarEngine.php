<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarEngine extends Model
{
    protected $fillable = ['name', 'car_size_id'];

    public function checks()
    {
        return $this->hasMany(Check::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function carSize()
    {
        return $this->belongsTo(CarSize::class);
    }
}
