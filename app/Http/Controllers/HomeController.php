<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use App\Models\News;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $highlights = Highlight::latest()->take(10)->get();
        $activities = News::latest()->skip(5)->take(10)->get();
        $bigNews = News::latest()->take(5)->get();
        $sponsors = Sponsor::orderBy('name')->get();

        return view('index', compact(
            'highlights',
            'activities',
            'bigNews',
            'sponsors'
        ));
    }
}
