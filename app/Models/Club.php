<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'city',
        'director_club',
        'administrator',
        'technical_director',
        'training_venue',
        'email',
        'contact_person',
        'website',
        'founded_year',
        'status',
    ];
}
