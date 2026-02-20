<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigNews extends Model
{
    protected $table = 'big_news';

    protected $fillable = [
    'title',
    'slug',
    'image',
    'link', 
    'content',
];
    public function getRouteKeyName()
{
    return 'slug';
}

}
