<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Livestream extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'event_id',
        'match_id',
        'stream_url',
        'status',
        'started_at',
        'ended_at',
    ];

    public function match(): HasOne
    {
        return $this->hasOne(BallMatch::class);
    }
    public function event(): HasOne
    {
        return $this->hasOne(Event::class);
    }
}
