<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visi extends Model
{
    protected $table = 'visi';

    protected $fillable = [
        'kicker',
        'title',
        'mobile_title',
        'mobile_desc',
        'visi',
        'misi',
        'image',
    ];
}
