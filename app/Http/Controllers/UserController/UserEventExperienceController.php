<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\EventExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserEventExperienceController extends Controller
{
    public function index()
    {
        $experiences = EventExperience::where('user_id', Auth::id())->latest()->get();
        return view('user.profile.event-experiences', compact('experiences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'team_name' => 'required|string|max:255',
            'event_regency' => 'required|string|max:255',
            'event_province' => 'required|string|max:255',
            'event_role' => ['required', Rule::in(config('dropdown.event_roles'))],
            'court_type' => ['required', Rule::in(config('dropdown.court_types'))],
            'event_format' => ['required', Rule::in(config('dropdown.event_formats'))],
            'competition_level' => ['required', Rule::in(config('dropdown.competition_levels'))],
            'participant_scope' => ['required', Rule::in(config('dropdown.participant_scopes'))],
            'age_category' => ['required', Rule::in(config('dropdown.age_categories'))],
            'event_start_date' => 'required|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_start_date',
            'result' => ['required', Rule::in(config('dropdown.results'))],
        ]);

        $data = $request->except('_token');
        $data['user_id'] = Auth::id();

        EventExperience::create($data);

        return back()->with('success', 'Pengalaman Event berhasil ditambahkan.');
    }

    public function destroy(EventExperience $event_experience)
    {
        if ($event_experience->user_id !== Auth::id()) {
            abort(403);
        }

        $event_experience->delete();
        return back()->with('success', 'Pengalaman Event berhasil dihapus.');
    }
}
