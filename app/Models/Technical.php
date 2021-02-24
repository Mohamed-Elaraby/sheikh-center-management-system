<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    protected $fillable = ['name', 'branch_id'];

    protected $hidden = ['pivot'];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function checks()
    {
        return $this -> belongsToMany(Check::class, 'relation_check_technicals', 'technical_id', 'check_id');
    }
}
