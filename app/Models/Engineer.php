<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    protected $fillable = ['name', 'branch_id'];

    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function checks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this -> hasMany(Check::class);
    }
}
