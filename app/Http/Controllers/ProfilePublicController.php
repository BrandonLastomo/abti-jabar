<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TeamProfile;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfilePublicController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'indoor');
        $subcategory = $request->query('subcategory', 'Senior putra');

        $teamProfile = TeamProfile::where('category', $category)
            ->where('subcategory', $subcategory)
            ->first();

        // Get events for the selected category and subcategory
        $events = Event::where('category', $category)
            ->where('subcategory', $subcategory)
            ->orderBy('event_date', 'desc')
            ->get();

        // Group by year
        $groupedEvents = $events->groupBy(function ($event) {
            if ($event->event_date) {
                return Carbon::parse($event->event_date)->format('Y');
            }
            return Carbon::parse($event->created_at)->format('Y');
        });

        // Subcategories list for the tabs
        $subcategories = [
            'indoor' => ['Senior putra', 'Senior putri', 'U-21 putra', 'U-21 putri', 'U-17 putra', 'U-17 putri', 'U-15 putra', 'U-15 putri'],
            'beach' => ['Senior putra', 'Senior putri', 'U-21 putra', 'U-21 putri', 'U-17 putra', 'U-17 putri', 'U-15 putra', 'U-15 putri'],
            'wheelchair' => ['Lihat Semua Tim']
        ];

        return view('profile', compact(
            'category',
            'subcategory',
            'teamProfile',
            'groupedEvents',
            'subcategories'
        ));
    }
}
