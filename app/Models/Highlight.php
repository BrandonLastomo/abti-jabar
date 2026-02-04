<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Highlight extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'match_id',
        'video_url',
    ];

    public function match(): HasOne
    {
        return $this->hasOne(BallMatch::class);
    }
}
