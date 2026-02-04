<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'level',
        'start_date',
        'end_date',
        'place',
        'status',
    ];

    public function livestream(): HasOne
    {
        return $this->hasOne(Livestream::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(BallMatch::class);
    }
}
