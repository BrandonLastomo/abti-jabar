<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'kicker',
        'title',
        'mobile_title',
        'mobile_desc',
        'desc',
        'timeline',
        'image',
    ];
}
