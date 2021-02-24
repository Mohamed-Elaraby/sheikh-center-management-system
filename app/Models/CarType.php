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

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'relation_car_type_clients', 'car_type_id', 'client_id');
    }
}
