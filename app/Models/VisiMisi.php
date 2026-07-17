<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misi';
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
