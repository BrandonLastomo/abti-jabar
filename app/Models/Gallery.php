<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'season'];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class);
    }
}
