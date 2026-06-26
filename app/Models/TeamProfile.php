<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamProfile extends Model
{
    protected $fillable = [
        'category',
        'subcategory',
        'picture'
    ];
}
