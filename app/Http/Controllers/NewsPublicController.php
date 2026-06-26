<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsPublicController extends Controller
{
    public function show(News $news)
    {
        $otherNews = News::where('id', '!=', $news->id)->latest()->take(3)->get();
        return view('news.show', compact('news', 'otherNews'));
    }
}
