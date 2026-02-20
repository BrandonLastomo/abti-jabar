<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'name',
        'slug',
        'desc',
        'date',
        'image',
        'link', // Tambahkan ini
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}