<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'category',
        'subcategory',
        'event_date',
        'loc',
        'athletes',
        'coaches',
        'teams',
        'management',
        'audience_offline',
        'website',
        'administrator',
        'logo',
        'cover',
    ];
}
