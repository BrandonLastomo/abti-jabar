<?php

namespace App\Http\Controllers\CMSController;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\ClubStaff;
use Illuminate\Http\Request;

class ClubStaffController extends Controller
{
    public function index(Club $club)
    {
        $page = 'profile';
        // Get existing staff grouped by position to make form pre-filling easier
        $staff = $club->staff()->get()->groupBy('position');
        
        return view('cms.club.staff.index', compact('club', 'staff', 'page'));
    }

    public function store(Request $request, Club $club)
    {
        $request->validate([
            'staff' => 'nullable|array',
            'staff.*.name' => 'nullable|string|max:255',
            'staff.*.position' => 'nullable|string|max:255',
        ]);

        // Delete all existing staff for this club
        $club->staff()->delete();

        $staffData = [];
        if ($request->has('staff') && is_array($request->staff)) {
            foreach ($request->staff as $staffItem) {
                if (!empty($staffItem['name']) && !empty($staffItem['position'])) {
                    $staffData[] = [
                        'club_id' => $club->id,
                        'name' => $staffItem['name'],
                        'position' => $staffItem['position'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($staffData)) {
            ClubStaff::insert($staffData);
        }

        return redirect()->route('club.staff.index', $club->id)->with('success', 'Club Staff updated successfully.');
    }
}
