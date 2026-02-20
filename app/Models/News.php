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
        'cta_text',
        'youtube_url',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
