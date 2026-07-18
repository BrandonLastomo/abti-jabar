<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WestJavaVideos extends Model
{
    protected $fillable = [
        'court_type',
        'link',
        'type',
    ];

    public function getEmbedLinkAttribute()
    {
        $url = $this->link;

        // If it's already an embed link, return as is
        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        // Handle youtu.be/ID
        if (str_contains($url, 'youtu.be/')) {
            $id = explode('youtu.be/', $url)[1];
            // Remove any query params like ?si=
            $id = explode('?', $id)[0];
            return 'https://www.youtube.com/embed/' . $id;
        }

        // Handle youtube.com/watch?v=ID
        if (str_contains($url, 'youtube.com/watch')) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (isset($params['v'])) {
                return 'https://www.youtube.com/embed/' . $params['v'];
            }
        }

        // Handle youtube.com/shorts/ID
        if (str_contains($url, 'youtube.com/shorts/')) {
            $id = explode('youtube.com/shorts/', $url)[1];
            $id = explode('?', $id)[0];
            return 'https://www.youtube.com/embed/' . $id;
        }

        // Fallback
        return $url;
    }
}
