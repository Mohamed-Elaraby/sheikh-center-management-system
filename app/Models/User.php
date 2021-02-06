<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image_path', 'image_name', 'role_id', 'branch_id', 'job_title_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['profile_picture_path'];

    public function getProfilePicturePathAttribute()
    {
        return 'storage' . DIRECTORY_SEPARATOR . $this->image_path . DIRECTORY_SEPARATOR . $this->image_name;
    }

    public function role()
    {
        return $this -> belongsTo(Role::class);
    }

    public function check()
    {
        return $this -> hasMany(Check::class);
    }

    public function branch()
    {
        return $this -> belongsTo(Branch::class);
    }

    public function jobTitle()
    {
        return $this -> belongsTo(JobTitle::class);
    }
}
