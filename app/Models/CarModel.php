<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = ['name'];

    public function checks()
    {
        return $this->hasMany(Check::class);
    }
}
