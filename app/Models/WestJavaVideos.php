<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WestJavaVideos extends Model
{
    protected $fillable = [
        'title',
        'court_type',
        'link',
        'type',
    ];
}
