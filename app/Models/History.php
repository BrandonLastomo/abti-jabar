<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'kicker',
        'title',
        'desc',
        'timeline',
        'image',
    ];
}
