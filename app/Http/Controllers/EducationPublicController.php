<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\News;
use Illuminate\Http\Request;

class EducationPublicController extends Controller
{
    public function index(Request $request)
    {
        $categories = Education::select('category')->distinct()->pluck('category')->toArray();
        if (empty($categories)) {
            // Default categories if database is empty to show the UI
            $categories = ['Multiplier', 'Coach', 'Goalkeeper Coach', 'Referee', 'Delegates', 'Training Management', 'Club Management'];
        }

        $activeCategory = $request->query('category', $categories[0] ?? 'Coach');

        $education = Education::where('category', $activeCategory)->first();

        // Get related news (Materi Terkait)
        $relatedNews = News::latest()->take(2)->get();

        return view('education', compact('categories', 'activeCategory', 'education', 'relatedNews'));
    }
}
