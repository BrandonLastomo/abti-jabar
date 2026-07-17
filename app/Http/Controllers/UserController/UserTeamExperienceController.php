<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\UserTeamExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTeamExperienceController extends Controller
{
    public function index()
    {
        $experiences = UserTeamExperience::where('user_id', Auth::id())->latest()->get();
        return view('user.profile.team-experiences', compact('experiences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'team_type' => 'required|in:nasional,provinsi,kab/kota,klub',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        UserTeamExperience::create([
            'user_id' => Auth::id(),
            'team_name' => $request->team_name,
            'team_type' => $request->team_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success', 'Pengalaman Tim berhasil ditambahkan.');
    }

    public function destroy(UserTeamExperience $team_experience)
    {
        if ($team_experience->user_id !== Auth::id()) {
            abort(403);
        }

        $team_experience->delete();
        return back()->with('success', 'Pengalaman Tim berhasil dihapus.');
    }
}
