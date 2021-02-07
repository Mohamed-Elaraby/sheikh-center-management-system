<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function checks(): HasMany
    {
        return $this -> hasMany(Check::class);
    }

    public function users(): HasMany
    {
        return $this -> hasMany(User::class);
    }

    public function technicals(): HasMany
    {
        return $this -> hasMany(Technical::class);
    }
    public function engineers(): HasMany
    {
        return $this -> hasMany(Engineer::class);
    }
}
