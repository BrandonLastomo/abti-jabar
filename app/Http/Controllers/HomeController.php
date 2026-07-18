<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Sponsor;
use App\Models\WestJavaVideos;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero = \App\Models\Hero::first();
        $highlights = WestJavaVideos::where('type', 'highlights')->latest()->take(10)->get();
        $bigNews = \App\Models\News::where('category', 'Inspirational')->latest()->take(3)->get();
        $internationalNews = \App\Models\News::where('category', 'News')->latest()->take(3)->get();
        $kegiatan = \App\Models\Kegiatan::latest()->take(3)->get();
        $sponsors = Sponsor::orderBy('name')->get();

        // Ambil livestream yang sedang berjalan dan terbaru
        // Note: Live model removed in DBML v2. Passed as null to prevent UI crash.
        $activeLive = null;

        return view('index', compact(
            'hero',
            'highlights',
            'bigNews',
            'internationalNews',
            'kegiatan',
            'sponsors',
            'activeLive' 
        ));
    }
}
