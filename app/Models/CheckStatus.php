<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckStatus extends Model
{
    protected $fillable = ['name', 'color'];

    public function check()
    {
        return $this -> hasMany(Check::class);
    }
}
