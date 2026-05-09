<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'title',
        'link',
        'date',
        'time',
        'is_live',
    ];
 
    protected $casts = [
        'is_live' => 'boolean',
        'date'    => 'date',
    ];
 
    /**
     * Scope: hanya yang sedang live
     */
    public function scopeActive($query)
    {
        return $query->where('is_live', true);
    }
 
    /**
     * Extract YouTube video ID dari berbagai format URL
     */
    public function getVideoIdAttribute(): ?string
    {
        preg_match(
            '/(youtu\.be\/|v=|\/live\/|embed\/)([a-zA-Z0-9_-]+)/',
            $this->link,
            $matches
        );
        return $matches[2] ?? null;
    }
 
    /**
     * Generate embed URL dari link
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $videoId = $this->video_id;
        if (!$videoId) return null;
        return "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0";
    }
}