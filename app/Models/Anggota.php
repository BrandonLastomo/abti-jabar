<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'city',
        'slug',
        'lead_name',
        'sec_name',
        'email',
        'link',
        'logo',
    ];

public function getRouteKeyName()
{
    return 'slug';
}

}
  

    

