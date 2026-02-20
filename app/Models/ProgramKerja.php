<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $table = 'program_kerja';

    protected $fillable = [
        'title',
        'slug',
        'hero_meta',
        'category',
        'year',
        'doc',
        'desc',
        'thumbnail_text',
        'image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
