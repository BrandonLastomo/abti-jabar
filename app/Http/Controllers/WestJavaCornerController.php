<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\WestJavaVideos;

class WestJavaCornerController extends Controller
{
    public function index()
    {
        $latestNews = News::latest()->paginate(5);
        $moreNews = News::latest()->skip(5)->take(6)->get();

        $podcasts = WestJavaVideos::where('type', 'podcast')
            ->latest()
            ->get();

        $shorts = WestJavaVideos::where('type', 'shorts')
            ->latest()
            ->get();

        return view('west-java-corner', compact(
            'podcasts',
            'shorts',
            'latestNews',
            'moreNews'
        ));
    }
}