<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    protected $fillable = [
//        'counter_number' ,
        'chassis_number',
        'plate_number' ,
        'car_color',
        'client_id',
        'car_type_id',
        'car_size_id',
        'car_model_id',
        'car_engine_id',
        'car_development_code_id',
    ];

    protected function setChassisNumberAttribute($value)
    {
        return $this -> attributes['chassis_number'] = strtoupper($value);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function carSize(): BelongsTo
    {
        return $this -> belongsTo(CarSize::class);
    }

    public function carModel(): BelongsTo
    {
        return $this -> belongsTo(CarModel::class);
    }

    public function carEngine(): BelongsTo
    {
        return $this -> belongsTo(CarEngine::class);
    }

    public function carDevelopmentCode(): BelongsTo
    {
        return $this -> belongsTo(CarDevelopmentCode::class);
    }

    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
