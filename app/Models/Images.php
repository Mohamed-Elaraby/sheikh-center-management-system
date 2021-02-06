<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = ['image_name', 'type', 'image_path', 'check_id'];

    protected $appends = ['check_images_path'];

    public function getCheckImagesPathAttribute()
    {
        return 'storage' . DIRECTORY_SEPARATOR . $this->image_path . DIRECTORY_SEPARATOR . $this->image_name;
    }

    public function check()
    {
        return $this -> belongsTo(Check::class);
    }
}
