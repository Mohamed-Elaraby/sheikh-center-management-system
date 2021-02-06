<?php

namespace App\Models;

use App\Observers\ClientObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'employer', 'other_car', 'how_you_now_us'];

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value) -> format('d/m/Y h:i:s a');
    }

    protected static function boot()
    {
        parent::boot();
        Client::observe(ClientObserver::class);
    }

    public function checks()
    {
        return $this -> hasMany(Check::class);
    }
}
