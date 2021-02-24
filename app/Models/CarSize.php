<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarSize extends Model
{
    protected $fillable = ['name', 'car_type_id'];


    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function engines()
    {
        return $this->hasMany(CarEngine::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function checks()
    {
        return $this->hasMany(Check::class);
    }

    public function developmentCodes()
    {
        return $this->hasMany(CarDevelopmentCode::class);
    }
}
