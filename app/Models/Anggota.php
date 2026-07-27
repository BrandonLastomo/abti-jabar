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
        'secretariat_name',
        'phone_number',
        'email',
        'link',
        'logo',
    ];

public function getRouteKeyName()
{
    return 'slug';
}

}
  

    

