<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',

        'images',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
