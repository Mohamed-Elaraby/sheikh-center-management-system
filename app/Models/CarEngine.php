<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CarEngine
 *
 * @property int $id
 * @property string $name
 * @property int $car_size_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CarSize $carSize
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Car[] $cars
 * @property-read int|null $cars_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Check[] $checks
 * @property-read int|null $checks_count
 * @method static \Illuminate\Database\Eloquent\Builder|CarEngine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarEngine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarEngine query()
 * @mixin \Eloquent
 */
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