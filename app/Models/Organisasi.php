<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $table = 'organisasi';

    protected $fillable = [
        'kicker',
        'title',
        'mobile_title',
        'mobile_desc',
        'desc',
        'tag',
        'image',
    ];
}
