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
        'category',
        'subcategory',
        'logo',
        'name',
        'pengcab_address',
        'office_address',
        'office_address_complete',
        'venue_address',
        'venue_address_complete',
        'website',
        'email',
        'phone',
        'club_status',
        'picture',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(ClubDocument::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(ClubStaff::class);
    }
}
