<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Expr\Match_;

class BallMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'event_id',
        'home_club_id',
        'away_club_id',
        'match_date',
        'score_home',
        'score_away',
    ];

    public function home_club(): HasOne
    {
        return $this->hasOne(CLub::class);
    }

    public function away_club(): HasOne
    {
        return $this->hasOne(CLub::class);
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(Highlight::class);
    }

    public function livestream(): HasOne
    {
        return $this->hasOne(Livestream::class);
    }

    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }
}
