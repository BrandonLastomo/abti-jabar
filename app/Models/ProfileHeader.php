<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileHeader extends Model
{
    protected $table = 'profile_header';

    protected $fillable = [
        'black_title',
        'red_title',
        'subtitle',
    ];
}
