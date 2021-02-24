<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation_check_technical extends Model
{
    protected $fillable = ['check_id', 'technical_id'];
    public $timestamps = false;
}
