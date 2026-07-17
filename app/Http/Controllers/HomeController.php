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
        $highlights = WestJavaVideos::where('type', 'highlights')->latest()->take(10)->get();
        $activities = News::latest()->skip(5)->take(10)->get();
        $bigNews = News::latest()->take(5)->get();
        $sponsors = Sponsor::orderBy('name')->get();

        // Ambil livestream yang sedang berjalan dan terbaru
        // Note: Live model removed in DBML v2. Passed as null to prevent UI crash.
        $activeLive = null;

        return view('index', compact(
            'highlights',
            'activities',
            'bigNews',
            'sponsors',
            'activeLive' 
        ));
    }
}
