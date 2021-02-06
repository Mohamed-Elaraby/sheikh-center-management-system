<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'status'];

//    protected static function boot()
//    {
//        parent::boot();
//        Client::observe(ClientObserver::class);
//    }

    public function getStatusAttribute($value)
    {
        return $value == false?__('trans.close'):__('trans.open');
    }

    public function checks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this -> hasMany(Check::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this -> hasMany(User::class);
    }

    public function technicals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this -> hasMany(Technical::class);
    }
    public function engineers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this -> hasMany(Engineer::class);
    }
}
