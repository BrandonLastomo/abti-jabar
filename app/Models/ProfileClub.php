<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileClub extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'city',
        'director',
        'admin',
        'technical_director',
        'training_venue',
        'email',
        'contact_person',
        'logo',
    ];
}
